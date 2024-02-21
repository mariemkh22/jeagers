<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Form\CommandeType;
use App\Form\EditCommandeType;
use App\Form\EditProduitType;
use App\Form\ProduitType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BackendController extends AbstractController
{
    #[Route('/backendhome', name: 'backendhome')]
    public function backendhome(): Response
    {
        return $this->render('backend/backendhome.html.twig', [
            'controller_name' => 'BackendController',
        ]);
    }

    #[Route('/displayProducts', name: 'displayProducts')]
    public function displayProducts(ProduitRepository $ProduitRepository): Response
    {
        $produit=$ProduitRepository->findAll();
        return $this->render('backend/ProductList.html.twig', [
            'table' => $produit
        ]);
    }
    
    #[Route('/addProduct', name: 'addProduct')]
    public function addProduct(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $produit=new Produit();
        $form=$this->createForm(ProduitType::class,$produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($produit);
            $m->flush();

            return $this->redirectToRoute('displayProducts');
        }
        return $this->render('backend/addProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(ProduitRepository $ProduitRepository, ManagerRegistry $managerRegistry, Request $request, $id):Response
    {
        $m=$managerRegistry->getManager();
        $findid=$ProduitRepository->find($id);
        $form=$this->createForm(EditProduitType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('displayProducts');
        }
        return $this->render('backend/editProductbyid.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/delete/{id}', name: 'delete')]
    public function delete(ProduitRepository $ProduitRepository, ManagerRegistry $managerRegistry, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$ProduitRepository->find($id);
        $m->remove($findid);
        $m->flush();
        return $this->redirectToRoute('displayProducts');
    }






#backendCommande
    #[Route('/displayComd', name: 'displayComd')]
    public function displayComd(CommandeRepository $CommandeRepository): Response
    {
        $cmd=$CommandeRepository->findAll();
        return $this->render('backend/CommandeList.html.twig', [
            'table' => $cmd
        ]);
    }
    #[Route('/addComd', name: 'addComd')]
    public function addComd(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $cmd=new Commande();
        $form=$this->createForm(CommandeType::class,$cmd);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($cmd);
            $m->flush();

            return $this->redirectToRoute('displayComd');
        }
        return $this->render('backend/addCommande.html.twig', [
            'form' => $form->createView()
        ]);
    }
  
    #[Route('/editc/{id}', name: 'editc')]
    public function editc(CommandeRepository $CommandeRepository, ManagerRegistry $managerRegistry, Request $request, $id):Response
    {
        $m=$managerRegistry->getManager();
        $findid=$CommandeRepository->find($id);
        $form=$this->createForm(EditCommandeType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('displayComd');
        }
        return $this->render('backend/editCommandebyid.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/deletec/{id}', name: 'deletec')]
    public function deletec(CommandeRepository $CommandeRepository, ManagerRegistry $managerRegistry, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$CommandeRepository->find($id);
        $m->remove($findid);
        $m->flush();
        return $this->redirectToRoute('displayComd');
    }
}