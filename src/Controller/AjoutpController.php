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
use Symfony\Component\Routing\Annotation\Route;

class AjoutpController extends AbstractController
{
    #[Route('/displayP', name: 'displayP')]
    public function displayP(ProduitRepository $repo,Request $request,PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repo->paginationQuery(),
            $request->query->get('page',1),3


        );
        return $this->render('frontend/produit.html.twig', [
           
            'pagination'=>$pagination
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
        return $this->render('frontend/ajouterproduit.html.twig', [
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
        return $this->render('frontend/Editproduit.html.twig', [
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