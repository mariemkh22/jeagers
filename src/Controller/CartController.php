<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/Dcart/{id?}', name: 'Dcart')]
    public function Dcart(SessionInterface $session, ProduitRepository $produitRepository): Response
    {
        // Fetch the cart data from the session
        $panier = $session->get('panier', []);

        // Fetch the products that are in the cart
        $produitsInCart = [];
        foreach ($panier as $id => $quantity) {
            $produit = $produitRepository->find($id);
            if ($produit !== null) {
                $produitsInCart[] = $produit;
            }
        }

        // Render the cart view with only the products in the cart
        return $this->render('frontend/cart.html.twig', [
            'table' => $produitsInCart,
        ]);
    }

    #[Route('/addCart/{id}', name: 'addCart')]
    public function addCart($id, SessionInterface $session): Response
    {
        // Get the cart from the session
        $panier = $session->get('panier', []);

        // Add the product to the cart
        if (!isset($panier[$id])) {
            $panier[$id] = 1; // Assuming default quantity is 1
            $session->set('panier', $panier);
        }

        // Redirect back to the cart page
        return $this->redirectToRoute('displayPG');
    }


    #[Route('/removeCart/{id}', name: 'removeCart')]
    public function removeCart($id, SessionInterface $session): Response
    {
        // Get the cart from the session
        $panier = $session->get('panier', []);
    
        // Check if the product exists in the cart
        if (isset($panier[$id])) {
            // Remove the product from the cart
            unset($panier[$id]);
            $session->set('panier', $panier);
        }
    
        // Redirect back to the cart page
        return $this->redirectToRoute('Dcart');
    }







}

