<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Play;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="profile")
     */
    public function index($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $playRepository = $this->getDoctrine()->getRepository(Play::class);

        $user = $userRepository->findOneById($id);

        if($user == null){
            return $this->redirectToRoute('home');
        }

        ///////////////////////////////////////////////////////////////////
        // Obtener array con el objeto de las partidas ganadas y perdidas
        $usersPlaysWon =  $playRepository->findWinsByUserId($id);
        $usersPlaysLost = $playRepository->findLosesByUserId($id);

        // Calcular las kills realizadas cuando ha ganado y cuando ha perdido para calcular el KD
        $killsW = 0;
        $killsL = 0;
        $deathW = 0;
        $deathL = 0;

        foreach($usersPlaysWon as $match){
            $killsW += $match->getUserkills();
            $deathW += $match->getOpponentkills();
        };
        foreach($usersPlaysLost as $match){
            $killsL += $match->getUserkills();
            $deathL += $match->getOpponentkills();
        };
        $allKills = $killsW + $killsL;
        $allDeaths = $deathW + $deathL;
        $kd = 0;
        if($allDeaths != 0){
            $kd = number_format($allKills / $allDeaths, 2);
        }
        
        // Contar las victorias de partidas ganadas y perdidas + Calcular average
        $user_wins  = count($usersPlaysWon);
        $user_lose = count($usersPlaysLost);

        $totalMatches = $user_wins + $user_lose;
        $winrate = 0;
        $average = 0;
        if ($totalMatches > 0){
            $winrate = round($user_wins / $totalMatches * 100);
            $average = round($allKills / $totalMatches);
        }

        //  Mostrar barra elo
        $elo = $user->getElo();
        $percent = round($elo*100/450);

        // Mostras porcentaje de los mapas
        $plays = array_merge($usersPlaysLost, $usersPlaysWon);

        // Calcular los años del usuario.
        $userYear = $user->getBirth()->format("Y");
        $currentYear = date('Y');
        $age = $currentYear - $userYear;
        
    
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'totalW' => $user_wins,
            'totalL' => $user_lose,
            'total' => $totalMatches,
            'winrate' => $winrate,
            'kd' => $kd,
            'avg' => $average,
            'totalKills' => $allKills,
            'totalDeaths' => $allDeaths,
            'percentbar' => $percent,
            'plays' => $plays,
            'currentuser' => $this->getUser(),
            'age' => $age,
        ]);
    }
    
    /**
     * @Route("/user/{id}/edit", name="edit_profile")
     */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneById($id);
        $currentUser = $this->getUser();



        if($this->getUser()->getId() == $id || in_array("ROLE_ADMIN", $this->getUser()->getRoles())){
            return $this->render('user/edit.html.twig', [
                'controller_name' => 'UserController',
                'userId' => $user->getId(), //NECESARIO PARA LA RUTA
                'user' => $user,  //NECESARIO PARA LA VISTA
                'currentUser' => $currentUser,
            ]);
        }else{   
            return $this->redirectToRoute('profile', ['id' => $this->getUser()->getId()]);
        }
    }

    /**
     * @Route("/save/{userId}", name="save_profile", methods={"GET", "POST"})
     */
    public function save($userId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $userEdited = $userRepository->findOneById($userId);

        $userEdited->setName($request->request->get("fname"));
        $userEdited->setSurname($request->request->get("surname"));
        $userEdited->setCountry($request->request->get("country"));
        $userEdited->setCity($request->request->get("city"));

        // $file = $request->request->get("imgProfile");
        // // $ext = $file->guessExtension();
        // $ext = substr($file, -3);
        // $file_name = $userEdited->getNick() . "." . $ext;
        // $file->move("./img/imgUser", $file_name);
        // $userEdited->setImgUser($file_name);
        
        $userEdited->setTwitter($request->request->get("twitter"));
        $userEdited->setFacebook($request->request->get("facebook"));
        $userEdited->setTwitch($request->request->get("twitch"));

        if(in_array("ROLE_ADMIN", $userEdited->getRoles())){
            $userEdited->setEmail($request->request->get("email"));
        }

        $em->persist($userEdited);
        $em->flush();

        return $this->redirectToRoute('profile', ['id' => $userId]);
        // return $this->render('user/error.html.twig', [
        //     'controller_name' => 'UserController',
        //     'userId' => $userId,
        //     'error' => $request->request->get("imgProfile"),
        //     'file' => $file_name,
        // ]);
    }
}
