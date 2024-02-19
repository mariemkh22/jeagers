<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'produit')]
    public function produit(): Response
    {
        return $this->render('produit/produit.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }

    #[Route('/addProduct', name: 'addProduct')]
    public function addProduct(): Response
    {
        return $this->render('produit/addProduct.html.twig', [
            'controller_name' => 'AjoutpController',
        ]);
    }
}
