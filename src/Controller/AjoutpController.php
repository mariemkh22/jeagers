<?php

namespace App\Controller;
use App\Entity\Produit;
use App\Form\EditProduitType;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjoutpController extends AbstractController
{   

    #[Route('/displayP', name: 'displayP')]
    public function displayP(ProduitRepository $produitRepository): Response
    {
        $product=$produitRepository->findAll();
        return $this->render('produit/produit.html.twig', [
            'table' => $product,
        ]);
    }

    #[Route('/addProductFE', name: 'addProductFE')]
    public function addProductFE(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $produit=new Produit();
        $form=$this->createForm(ProduitType::class,$produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($produit);
            $m->flush();

            return $this->redirectToRoute('displayP');
        }
        return $this->render('produit/ajouterproduit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/editFE/{id}', name: 'editFE')]
    public function editFE(ProduitRepository $ProduitRepository, ManagerRegistry $managerRegistry, Request $request, $id):Response
    {
        $m=$managerRegistry->getManager();
        $findid=$ProduitRepository->find($id);
        $form=$this->createForm(EditProduitType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('displayP');
        }
        return $this->render('produit/Editproduit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/deleteFE/{id}', name: 'deleteFE')]
    public function deleteFE(ProduitRepository $ProduitRepository, ManagerRegistry $managerRegistry, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$ProduitRepository->find($id);
        $m->remove($findid);
        $m->flush();
        return $this->redirectToRoute('displayP');
    }
}