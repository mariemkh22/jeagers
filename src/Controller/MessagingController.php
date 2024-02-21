<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagingController extends AbstractController
{
    #[Route('/messaging', name: 'app_messaging')]
    public function index(): Response
    {
        return $this->render('messaging/index.html.twig', [
            'controller_name' => 'MessagingController',
        ]);
    }
    #[Route('/contact', name: 'app_messaging')]
    public function contact(): Response
    {
        return $this->render('messaging/contact.html.twig', [
            'controller_name' => 'MessagingController',
        ]);
    }
    #[Route('/chatting', name: 'chatting')]
    public function chatting(): Response
    {
        return $this->render('messaging/chatting.html.twig', [
            'controller_name' => 'MessagingController',
        ]);
    }
}