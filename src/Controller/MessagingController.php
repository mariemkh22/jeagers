<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\MessagingRepository;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\ErrorCorrectionLevel;


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
        return $this->redirectToRoute('chatting.html.twig');
    }
    #[Route('/chatting', name: 'chatting')]
    public function chatting(): Response
    {
        return $this->render('messaging/chatting.html.twig', [
            'controller_name' => 'MessagingController',
        ]);
    }


   
}