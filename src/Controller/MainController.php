<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Item;
use App\Entity\User;
use Symfony\Component\Validator\Constraints\Date;



class MainController extends AbstractController
{
    
    /**
     * @Route("/terms-conditions", name="conditions")
     */
    public function loadConditions()
    {
        return $this->render('politics/terms-conditions.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/home", name="home")
     */
    public function loadHome()
    {   
        /* Para redirigir al hacer LOGIN: Security > LoginAuthenticator.php; onSuccess > return new RedirectResponse($this->urlGenerator->generate('home')); */
        // obtener usuario
        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        if( $this->getUser() ){
            $user = $userRepository->findOneById($this->getUser()->getId());
            $allUsers = $userRepository->findAllOrderByWins();
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
            
            return $this->render('main/home.html.twig', [
                'controller_name' => 'MainController',
                'user' => $user,
                'elomax' => $eloMax,
                'percentbar' => $percent,
                'users' => $allUsers,
                'size'  => count($allUsers),
 
            ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
        
    }


}
