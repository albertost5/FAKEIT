<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Support;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class SupportController extends AbstractController
{
    /**
     * @Route("/support", name="index_support")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $supportRepository = $this->getDoctrine()->getRepository(Support::class);
        $supports = $supportRepository->findAll();

        $nSupports = count($supports);


        return $this->render('support/index.html.twig', [
            'controller_name' => 'SupportController',
            'supports' => $supports,     
            'nsupports' => $nSupports,    
        ]);
    }

    /**
     * @Route("/support/new", name="new_support")
     */
    public function new()
    {
            
        return $this->render('support/new.html.twig', [
            'controller_name' => 'SupportController',
            'userId' => $this->getUser()->getId(),
        ]);
    }

    /**
     * @Route("/support/{userId}", name="save_support")
     */
    public function save($userId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepository->findOneById($userId);

        $support = new Support();
        $support->setUser($user);
        $support->setSubject($request->request->get("support_subject"));
        $support->setMessage($request->request->get("support_message"));
        $support->setDate(date('Y-m-d H:i:s'));

        $em->persist($support);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
