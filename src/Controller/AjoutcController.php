<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjoutcController extends AbstractController
{
    
    #[Route('/addComdFE', name: 'addComdFE')]
    public function addComdFE(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $cmd=new Commande();
        $form=$this->createForm(CommandeType::class,$cmd);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($cmd);
            $m->flush();

            return $this->redirectToRoute('displayComdFE');
        }
        return $this->render('frontend/ajoutercommande.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/displayComdFE', name: 'displayComdFE')]
    public function displayComdFE(CommandeRepository $CommandeRepository): Response
    {
        $cmd=$CommandeRepository->findAll();
        return $this->render('frontend/orderslist.html.twig', [
            'table' => $cmd
        ]);
    }


    #[Route('/deletecFE/{id}', name: 'deletecFE')]
    public function deletecFE(CommandeRepository $CommandeRepository, ManagerRegistry $managerRegistry, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$CommandeRepository->find($id);
        $m->remove($findid);
        $m->flush();
        return $this->redirectToRoute('displayComdFE');
    }


















}
