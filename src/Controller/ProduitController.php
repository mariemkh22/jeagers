<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }
    #[Route('/produit', name: 'app_produit')]
    public function produit(): Response
    {
        return $this->render('produit/produit.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }
}