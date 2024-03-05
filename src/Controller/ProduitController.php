<?php

namespace App\Controller;
use App\Entity\Produit;
use App\Form\EditProduitType;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/displayPG', name: 'displayPG')]
    public function displayPG(ProduitRepository $ProduitRepository,Request $request,PaginatorInterface $paginator): Response
    {
        
        $pagination = $paginator->paginate(
            $ProduitRepository->paginationQuery(),
            $request->query->get('page',1),3


        );
        return $this->render('frontend/productGenral.html.twig', [
           
            'pagination'=>$pagination
        ]);
    }

    #[Route('/markAsFavorite/{id}', name: 'markAsFavorite')]
public function markAsFavorite($id, SessionInterface $session, ProduitRepository $produitRepository): Response
{
    // Retrieve existing list of favorite product IDs from session
    $favoriteProducts = $session->get('favorite_products', []);

    // Check if the product is already marked as favorite
    if (!in_array($id, $favoriteProducts)) {
        // Add the product to favorites
        $favoriteProducts[] = $id;
        $session->set('favorite_products', $favoriteProducts);
    }

    // Redirect back to the product page or any other appropriate page
    return $this->redirectToRoute('displayPG');
}



    #[Route('/listFavorites', name: 'listFavorites')]
    public function listFavorites(SessionInterface $session, ProduitRepository $produitRepository): Response
    {
        // Retrieve list of favorite product IDs from session
        $favoriteProducts = $session->get('favorite_products', []);

        // Fetch product entities corresponding to the favorite product IDs
        $favoriteProductEntities = [];
        foreach ($favoriteProducts as $id) {
            $produit = $produitRepository->find($id);
            if ($produit !== null) {
                $favoriteProductEntities[] = $produit;
            }
        }

        // Render a template to display the list of favorite products
        return $this->render('frontend/favouriteListe.html.twig', [
            'table' => $favoriteProductEntities,
        ]);
    }


  
    #[Route('/removeFromFavorites/{id}', name: 'removeFromFavorites')]
public function removeFromFavorites($id, SessionInterface $session)
{
    // Retrieve existing list of favorite product IDs from session
    $favoriteProducts = $session->get('favorite_products', []);

    // Check if the product ID exists in the list of favorites
    $index = array_search($id, $favoriteProducts);
    if ($index !== false) {
        // Remove the product ID from the list of favorites
        unset($favoriteProducts[$index]);
        $session->set('favorite_products', array_values($favoriteProducts));
    }

    // Redirect back to the favorites list page
    return $this->redirectToRoute('listFavorites');
}





























    
}




























