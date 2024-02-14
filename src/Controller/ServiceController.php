<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'service')]
    public function service(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
   
    #[Route('/services', name: 'services')]
    public function services(): Response
    {
        return $this->render('service/services.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    #[Route('/addService', name: 'addService')]
    public function addService(): Response
    {
        return $this->render('service/addService.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }


}
