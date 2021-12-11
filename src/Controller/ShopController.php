<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Item;
use App\Entity\User;
use Symfony\Component\Validator\Constraints\Date;

class ShopController extends AbstractController
{
    // /**
    //  * @Route("/shop", name="shop")
    //  */
    // public function index()
    // {
    //     return $this->render('shop/index.html.twig', [
    //         'controller_name' => 'ShopController',
    //     ]);
    // }


    /**
     * @Route("/shop", name="shop")
     */
    public function loadShop()
    {   
        // obtener usuario
        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepository->findOneById($this->getUser()->getId());
        $usersAll = $userRepository->findAll();
        
        // obtener level del usuario
        $userLevel=  $user->getLevel();
        $userElo =  $user->getElo();
        
        $eloMin = 0;
        $eloMax = 49;
    
        if($userElo >= 50 && $userElo <= 99){
            $userLevel = 2;
            $eloMin = 50;
            $eloMax = 99;
        }elseif($userElo >= 100 && $userElo <= 149){
            $userLevel = 3;
            $eloMin = 100;
            $eloMax =149;
        }elseif($userElo >= 150 && $userElo <= 199){
            $userLevel = 4;
            $eloMin = 150;
            $eloMax = 199;
        }elseif($userElo >= 200 && $userElo <= 249){
            $userLevel = 5;
            $eloMin = 200;
            $eloMax = 249;
        }elseif($userElo >= 250 && $userElo <= 299){
            $userLevel = 6;
            $eloMin = 250;
            $eloMax = 299;
        }elseif($userElo >= 300 && $userElo <= 349){
            $userLevel = 7;
            $eloMin = 300;
            $eloMax = 349;
        }elseif($userElo >= 350 && $userElo <= 399){
            $userLevel = 8;
            $eloMin = 350;
            $eloMax = 399;
        }elseif($userElo >= 400 && $userElo <= 449){
            $userLevel = 9;
            $eloMin = 400;
            $eloMax = 449;
        }elseif($userElo >= 450){
            $userLevel = 10;
            $eloMin = 450;
            $eloMax = "~~";
        }

        $user->setLevel($userLevel);

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
        
        $buy50 = false;
        $buy150 = false;
        $buy200 = false;
        $buy300 = false;

        if($this->getUser()->getFakeitPoints() >= 50 && $this->getUser()->getFakeitPoints() < 150){
            $buy50 = true;
        }else if($this->getUser()->getFakeitPoints() >= 150 && $this->getUser()->getFakeitPoints() < 200){
            $buy50 = true;
            $buy150= true;
        }else if($this->getUser()->getFakeitPoints() >= 200 && $this->getUser()->getFakeitPoints() < 300){
            $buy50 = true;
            $buy150 = true;
            $buy200 = true;
        }else if($this->getUser()->getFakeitPoints() >= 300){
            $buy300 = true;
            $buy200 = true;
            $buy150 = true;
            $buy50 = true;
        }

        $em->flush();
        
        return $this->render('shop/shop.html.twig', [
            'controller_name' => 'MainController',
            'user' => $user,
            'elomax' => $eloMax,
            'percentbar' => $percent,
            'b50' => $buy50,
            'b150' => $buy150,
            'b200' => $buy200,
            'b300' => $buy300,
            'usersall' => $usersAll,
        ]);
    }


    /**
     * @Route("/buy/{cost}", name="buy_item")
     */
    public function buy($cost)
    {  

        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepository->findOneById($this->getUser()->getId());
        $userPoints = $user->getFakeitPoints();
        $userNewPoints = $userPoints - $cost;
        $user->setFakeitPoints($userNewPoints);
        

        $newItem = new Item();
        $name = "";
        
        //PASAR DATE TIME
        date_default_timezone_set('Europe/Brussels');
        $date = date('d-m-y H:i:s A');

        if($cost==50){
            $name = "FREE ELO";
            $user->setElo($user->getElo() + 25);
        }else if($cost==150){
            $name = "BOOST ONE";
            $user->setLevel($user->getLevel()+1);
        }else if($cost==200){
            $name = "BOOST TWO";
            $user->setLevel($user->getLevel()+2);
        }else if($cost==300){
            $name = "NICK CHANGE";
        }

        if($cost == 150 || $cost == 200){
            $currentLevel = $user->getLevel();
            if($currentLevel==2){
                $eloMin = 50;
            }elseif($currentLevel==3){
                $eloMin = 100;
            }elseif($currentLevel==4){
                $eloMin = 150;
            }elseif($currentLevel==5){
                $eloMin = 200;
            }elseif($currentLevel==6){
                $eloMin = 250;
            }elseif($currentLevel==7){
                $eloMin = 300;
            }elseif($currentLevel==8){
                $eloMin = 350;
            }elseif($currentLevel==9){
                $eloMin = 400;
            }elseif($currentLevel==10){
                $eloMin = 450;
            }
            $user->setElo($eloMin);
        }
        
        
        $newItem->setName($name);
        $newItem->setCost($cost);
        $newItem->setUser($user);
        $newItem->setDate($date);
    
        $em->persist($newItem);
        $em->flush();

        return $this->redirectToRoute('shop');
    }

    /**
     * @Route("/buy/change/{newnick}", name="buy_nickchange")
     */
    public function nickchange($newnick)
    {  
        // He tenido que poner la ruta buy/change/ porque si dejaba buy/{variable}, al no especificar el name de la ruta y usar la ruta absoluta, confundía rutas
        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepository->findOneById($this->getUser()->getId());
        $userPoints = $user->getFakeitPoints();
        $userNewPoints = $userPoints - 300;
        $user->setFakeitPoints($userNewPoints);
        $user->setNick($newnick);

        
        $newItem = new Item();
        $name = "NICK CHANGE";
        
        //PASAR DATE TIME
        date_default_timezone_set('Europe/Brussels');
        $date = date('d-m-y H:i:s A');
        
        $newItem->setName($name);
        $newItem->setCost(300);
        $newItem->setUser($user);
        $newItem->setDate($date);
    
        $em->persist($newItem);
        $em->flush();

        return $this->redirectToRoute('shop');
    }
}
