<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Entity\LocalisationGeographique;
use App\Form\LivraisonType;
use App\Form\LocalisationGeographiqueType;
use App\Repository\LivraisonRepository;
use App\Repository\LocalisationGeographiqueRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;


class LivraisonController extends AbstractController
{
    #[Route('/Livraisonlist', name: 'Livraisonlist')]
    public function Livraisonlist(LivraisonRepository $livraisonRepository): Response
    {
        $livraison=$livraisonRepository->findAll();
        return $this->render('delivery/Livraisonlist.html.twig', [
            'livraison' => $livraison,
        ]);
    }
    #[Route('/LocalisationGeographiquelist', name: 'LocalisationGeographiquelist')]
    public function LocalisationGeographiquelist(LocalisationGeographiqueRepository $localisationGeographiqueRepository): Response
    {
        $localisation=$localisationGeographiqueRepository->findAll();
        return $this->render('delivery/LocalisationGeographiquelist.html.twig', [
            'localisation' => $localisation,
        ]);
    }
    #[Route('/Ajoutdelivery', name: 'Ajoutdelivery')]
    public function Ajoutdelivery(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $w=$managerRegistry->getManager();
        $b=new Livraison();
        $form = $this->createForm(LivraisonType::class,$b);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $w->persist($b);
            $w->flush();
            $response = new RedirectResponse($this->generateUrl('Ajoutdelivery'));
            $response->setTargetUrl($this->generateUrl('sms'));
            return $response;

        }
        
        return $this->renderForm('delivery/Ajoutdelivery.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/Ajoutlocation', name: 'Ajoutlocation')]
    public function Ajoutlocation(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $k=$managerRegistry->getManager();
        $r=new LocalisationGeographique();
        $form = $this->createForm(LocalisationGeographiqueType::class,$r);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $k->persist($r);
            $k->flush();
            return $this->redirectToRoute('Ajoutlocation');
        }
        return $this->renderForm('delivery/Ajoutlocation.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/Modifdelivery/{id}', name: 'Modifdelivery')]
    public function Modifdelivery(LivraisonRepository $livraisonRepository, ManagerRegistry $managerRegistry,Request $req,$id): Response
    {
        $t=$managerRegistry->getManager();
        $s=$livraisonRepository->find($id);
        $form = $this->createForm(LivraisonType::class,$s);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $t->persist($s);
            $t->flush();
            return $this->redirectToRoute('Ajoutdelivery');
        }
        return $this->renderForm('delivery/Modifdelivery.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/Modiflocation/{id}', name: 'Modiflocation')]
    public function Modiflocation(LocalisationGeographiqueRepository $localisationGeographiqueRepository, ManagerRegistry $managerRegistry,Request $req,$id): Response
    {
        $t=$managerRegistry->getManager();
        $s=$localisationGeographiqueRepository->find($id);
        $form = $this->createForm(LocalisationGeographiqueType::class,$s);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $t->persist($s);
            $t->flush();
            return $this->redirectToRoute('Ajoutdelivery');
        }
        return $this->renderForm('delivery/Modiflocation.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/Suppdelivery/{id}', name: 'Suppdelivery')]
    public function Suppdelivery(LivraisonRepository $livraisonRepository, ManagerRegistry $managerRegistry,$id): Response
    {
        $x=$managerRegistry->getManager();
        $a=$livraisonRepository->find($id);
        $x->remove($a);
        $x->flush();
        return $this->redirectToRoute('Ajoutdelivery');
    }
    #[Route('/Supplocation/{id}', name: 'Supplocation')]
    public function Supplocation(LocalisationGeographiqueRepository $localisationGeographiqueRepository, ManagerRegistry $managerRegistry,$id): Response
    {
        $x=$managerRegistry->getManager();
        $a=$localisationGeographiqueRepository->find($id);
        $x->remove($a);
        $x->flush();
        return $this->redirectToRoute('Ajoutdelivery');
    }
}