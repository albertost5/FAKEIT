<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Map;
use App\Entity\Play;

class PlayController extends AbstractController
{
    /**
     * @Route("/play", name="play")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepository->findOneById($this->getUser()->getId());
        $users = count($userRepository->findAll());

        // CARGAR DATOS DEL USER EN EL NAVBAR, ASÍ COMO LAS ACTUALIZACIONES QUE SE PRODUZCAN
        // OBTENER EL LEVEL DEL USUARIO
        $userLevel= $user->getLevel();
        $userElo = $user->getElo();
        
        $eloMin = 0;
        $eloMax = 49;
    
        if($userLevel==2){
            $eloMin = 50;
            $eloMax = 99;
        }elseif($userLevel==3){
            $eloMin = 100;
            $eloMax = 149;
        }elseif($userLevel==4){
            $eloMin = 150;
            $eloMax = 199;
        }elseif($userLevel==5){
            $eloMin = 200;
            $eloMax = 249;
        }elseif($userLevel==6){
            $eloMin = 250;
            $eloMax = 299;
        }elseif($userLevel==7){
            $eloMin = 300;
            $eloMax = 349;
        }elseif($userLevel==8){
            $eloMin = 350;
            $eloMax = 399;
        }elseif($userLevel==9){
            $eloMin = 400;
            $eloMax = 449;
        }elseif($userLevel==10){
            $eloMin = 450;
            $eloMax = "~~";
        }

        if($userLevel != 10){
            if($userElo == $eloMin){
                $percent = 1;
            }elseif($userElo == $eloMin + 25){
                $percent = 50;
            }else{
                $percent = round($userElo*100/$eloMax);
            }
        }else{
            $percent = 100;
        }
        
        return $this->render('play/play.html.twig', [
            'controller_name' => 'PlayController',
            'user' => $user,
            'elomax' => $eloMax,
            'percentbar' => $percent,
            'users' =>  $users,
        ]);
    }

    /**
     * @Route("/play/match", name="ready")
     */
    public function preview()
    {

        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepository->findOneById($this->getUser()->getId());

        // CARGAR DATOS DEL USER EN EL NAVBAR, ASÍ COMO LAS ACTUALIZACIONES QUE SE PRODUZCAN
        // OBTENER EL LEVEL DEL USUARIO
        $userLevel= $user->getLevel();
        $userElo = $user->getElo();
        
        $eloMin = 0;
        $eloMax = 49;
    
        if($userLevel==2){
            $eloMin = 50;
            $eloMax = 99;
        }elseif($userLevel==3){
            $eloMin = 100;
            $eloMax = 149;
        }elseif($userLevel==4){
            $eloMin = 150;
            $eloMax = 199;
        }elseif($userLevel==5){
            $eloMin = 200;
            $eloMax = 249;
        }elseif($userLevel==6){
            $eloMin = 250;
            $eloMax = 299;
        }elseif($userLevel==7){
            $eloMin = 300;
            $eloMax = 349;
        }elseif($userLevel==8){
            $eloMin = 350;
            $eloMax = 399;
        }elseif($userLevel==9){
            $eloMin = 400;
            $eloMax = 449;
        }elseif($userLevel==10){
            $eloMin = 450;
            $eloMax = "~~";
        }

        if($userLevel != 10){
            if($userElo == $eloMin){
                $percent = 1;
            }elseif($userElo == $eloMin + 25){
                $percent = 50;
            }else{
                $percent = round($userElo*100/$eloMax);
            }
        }else{
            $percent = 100;
        }
        
        
        // REALIZAR ENFRENTAMIENTO ENTRE USUARIOS
        $users = $userRepository->findAll();
        
        // Obtener un random ID user para buscar el oponente
        $idUsers = [];
        foreach($users as $u){
            if($u->getId() != $this->getUser()->getId()){
                array_push($idUsers, $u->getId());
            }
            
        }
        
        // Se busca un número aleatorio entre las posiciones del array y que sea distinto al del usuario logueado
        $countIdUsers = count($idUsers);
        $positionIdUsers = rand(0, $countIdUsers - 1);
    
        // Cuando el número aleatorio es válido se busca el id del oponente y se devuelve un objeto User con dicho id
        $opponent = $userRepository->findOneById($idUsers[$positionIdUsers]);

        // Generar un random entre los mapas para escoger uno.
        $mapRepository = $this->getDoctrine()->getRepository(Map::class);
        $nMaps = count($mapRepository->findAll());
        $nRandomMap = rand(1, $nMaps);
        $mapRandom = $mapRepository->findOneById($nRandomMap);

        return $this->render('play/preview.html.twig', [
            'controller_name' => 'PlayController',
            'user' => $user,
            'elomax' => $eloMax,
            'percentbar' => $percent,
            'opponentUser' => $opponent,
            'map' => $mapRandom,
        ]);
    }
  
    /**
     * @Route("/play/{idUser}/{idOpponent}/{idMap}", name="versus")
     */
    public function versus($idUser,$idOpponent,$idMap)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $currentUser = $userRepository->findOneById($idUser);
        $opponentUser = $userRepository->findOneById($idOpponent);
       
        $match = new Play();
 
        
        $mapRepository = $this->getDoctrine()->getRepository(Map::class);
        $mapChoosen =  $mapRepository->findOneById($idMap);

        $match->setMap($mapChoosen);
        $match->setIdopponent($idOpponent);
        $match->setUser($currentUser);
        $match->setDate(date('Y-m-d H:i:s'));

        $random = rand(1,2);
        $loserKills = rand(0,14);

        if($random == 1 ){
            // USER A WINNER (CURRENT)
            $match->setWinnerId($currentUser->getId());
            $match->setUserkills(16);
            $currentUser->setElo($currentUser->getElo()+25);
            $currentUser->setWins($currentUser->getWins() + 1 );
            // USER B
            $match->setLoserId($opponentUser->getId());
            $match->setOpponentkills($loserKills);
            if($opponentUser->getElo() >= 10){
                $opponentUser->setElo($opponentUser->getElo()-10);
            }
        }else{
            // USER B WINNER
            $match->setWinnerId($opponentUser->getId());
            $match->setOpponentkills(16);
            $opponentUser->setElo($opponentUser->getElo()+25);
            $opponentUser->setWins($opponentUser->getWins() + 1 );
            // USER A (CURRENT) 
            $match->setLoserId($currentUser->getId());
            $match->setUserkills($loserKills);
            if($currentUser->getElo() >= 10){
                $currentUser->setElo($currentUser->getElo()-10);
            }
        }

        $opponentUser->setFakeitPoints($opponentUser->getFakeitPoints()+5);
        $currentUser->setFakeitPoints($currentUser->getFakeitPoints()+5);


        // ACTUALIZAR ELO
        $currentElo = $currentUser->getElo();
        $opponetElo = $opponentUser->getElo();

        // CURRENT USER
        if($currentElo <= 49 ){
            $currentUser->setLevel(1);
        }elseif($currentElo <= 99 ){
            $currentUser->setLevel(2);
        }elseif($currentElo <= 149){
            $currentUser->setLevel(3);
        }elseif($currentElo <= 199){
            $currentUser->setLevel(4);
        }elseif($currentElo <= 249){
            $currentUser->setLevel(5);
        }elseif($currentElo <= 299){
            $currentUser->setLevel(6);
        }elseif($currentElo <= 349){
            $currentUser->setLevel(7);
        }elseif($currentElo <= 399){
            $currentUser->setLevel(8);
        }elseif($currentElo <= 449){
            $currentUser->setLevel(9);
        }elseif($currentElo >= 450){
            $currentUser->setLevel(10);
        }

        // OPPONENT USER
        if($opponetElo <= 49 ){
            $opponentUser->setLevel(1);
        }elseif($opponetElo <= 99 ){
            $opponentUser->setLevel(2);
        }elseif($opponetElo <= 149){
            $opponentUser->setLevel(3);
        }elseif($opponetElo <= 199){
            $opponentUser->setLevel(4);
        }elseif($opponetElo <= 249){
            $opponentUser->setLevel(5);
        }elseif($opponetElo <= 299){
            $opponentUser->setLevel(6);
        }elseif($opponetElo <= 349){
            $opponentUser->setLevel(7);
        }elseif($opponetElo <= 399){
            $opponentUser->setLevel(8);
        }elseif($opponetElo <= 449){
            $opponentUser->setLevel(9);
        }elseif($opponetElo >= 450){
            $opponentUser->setLevel(10);
        }

        $em->persist($currentUser);
        $em->persist($opponentUser);
        $em->persist($match); 
        $em->flush();

        return $this->redirectToRoute('result', ['matchCreatedId' => $match->getId()]);
    }


    /**
     * @Route("/play/match/{matchCreatedId}", name="result")
     */
    public function result($matchCreatedId)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepository->findOneById($this->getUser()->getId());

        // CARGAR DATOS DEL USER EN EL NAVBAR, ASÍ COMO LAS ACTUALIZACIONES QUE SE PRODUZCAN
        // OBTENER EL LEVEL DEL USUARIO
        $userLevel= $user->getLevel();
        $userElo = $user->getElo();
        
        $eloMin = 0;
        $eloMax = 49;
    
        if($userLevel==2){
            $eloMin = 50;
            $eloMax = 99;
        }elseif($userLevel==3){
            $eloMin = 100;
            $eloMax = 149;
        }elseif($userLevel==4){
            $eloMin = 150;
            $eloMax = 199;
        }elseif($userLevel==5){
            $eloMin = 200;
            $eloMax = 249;
        }elseif($userLevel==6){
            $eloMin = 250;
            $eloMax = 299;
        }elseif($userLevel==7){
            $eloMin = 300;
            $eloMax = 349;
        }elseif($userLevel==8){
            $eloMin = 350;
            $eloMax = 399;
        }elseif($userLevel==9){
            $eloMin = 400;
            $eloMax = 449;
        }elseif($userLevel==10){
            $eloMin = 450;
            $eloMax = "~~";
        }

        if($userLevel != 10){
            if($userElo == $eloMin){
                $percent = 1;
            }elseif($userElo == $eloMin + 25){
                $percent = 50;
            }else{
                $percent = round($userElo*100/$eloMax);
            }
        }else{
            $percent = 100;
        }
        
        $matchRepository = $this->getDoctrine()->getRepository(Play::class);
        $matchCreated = $matchRepository->findOneById($matchCreatedId);

        $mapChoosen = $matchCreated->getMap();
        $opponentId = $matchCreated->getIdopponent();

        $opponentUser = $userRepository->findOneById($opponentId);

        return $this->render('play/result.html.twig', [
            'controller_name' => 'PlayController',
            'user' => $user,
            'elomax' => $eloMax,
            'percentbar' => $percent,
            'match' => $matchCreated,
            'map' => $mapChoosen,
            'opponent' => $opponentUser,
        ]);
    }
}
