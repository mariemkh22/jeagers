<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeliveryController extends AbstractController
{
    #[Route('/deliveryList', name: 'deliveryList')]
    public function deliveryList(): Response
    {
        return $this->render('delivery/delivery.html.twig', [
            'controller_name' => 'DeliveryController',
        ]);
    }
}
