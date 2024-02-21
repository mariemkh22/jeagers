<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
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

            return $this->redirectToRoute('displayComd');
        }
        return $this->render('frontend/ajoutercommande.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
