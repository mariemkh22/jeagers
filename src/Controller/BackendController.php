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

class BackendController extends AbstractController
{
    #[Route('/Deliverylist', name: 'Deliverylist')]
    public function Deliverylist(LivraisonRepository $livraisonRepository): Response
    {
        $livraison=$livraisonRepository->findAll();
        return $this->render('backend/Deliverylist.html.twig', [
            'Livraison' => $livraison,
        ]);
    }
    #[Route('/Locationlist', name: 'Locationlist')]
    public function Locationlist(LocalisationGeographiqueRepository $localisationGeographiqueRepository): Response
    {
        $location=$localisationGeographiqueRepository->findAll();
        return $this->render('backend/Locationlist.html.twig', [
            'location' => $location,
        ]);
    }
    #[Route('/annuler', name: 'annuler')]
    public function annuler(): Response
    {
        return $this->redirectToRoute('Deliverylist');
    }
    #[Route('/Back', name: 'Back')]
    public function Back(): Response
    {
        return $this->redirectToRoute('Locationlist');
    }
#Backend CRUD tab Location
    #[Route('/Addlocation', name: 'Addlocation')]
    public function Addlocation(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $w=$managerRegistry->getManager();
        $b=new LocalisationGeographique();
        $form = $this->createForm(LocalisationGeographiqueType::class,$b);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $w->persist($b);
            $w->flush();
            return $this->redirectToRoute('Locationlist');
        }
        return $this->renderForm('backend/Addlocation.html.twig', [
            'k' => $form,
        ]);
    }
    #[Route('/Editlocation/{id}', name: 'Editlocation')]
    public function Editlocation(LocalisationGeographiqueRepository $localisationGeographiqueRepository, ManagerRegistry $managerRegistry,Request $req,$id): Response
    {
        $t=$managerRegistry->getManager();
        $s=$localisationGeographiqueRepository->find($id);
        $form = $this->createForm(LocalisationGeographiqueType::class,$s);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $t->persist($s);
            $t->flush();
            return $this->redirectToRoute('Locationlist');
        }
        return $this->renderForm('backend/Editlocation.html.twig', [
            'p' => $form,
        ]);
    }
    #[Route('/Deletelocation/{id}', name: 'Deletelocation')]
    public function Deletelocation(LocalisationGeographiqueRepository $localisationGeographiqueRepository, ManagerRegistry $managerRegistry,Request $req,$id): Response
    {
        $r=$managerRegistry->getManager();
        $em=$localisationGeographiqueRepository->find($id);
        $r->remove($em);
        $r->flush();
        return $this->redirectToRoute('Locationlist');
    }
#Backend CRUD tab Livraison
    #[Route('/Adddelivery', name: 'Adddelivery')]
    public function Adddelivery(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $x=$managerRegistry->getManager();
        $y=new Livraison();
        $form = $this->createForm(LivraisonType::class,$y);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $x->persist($y);
            $x->flush();
            return $this->redirectToRoute('Deliverylist');
        }
        return $this->renderForm('backend/Adddelivery.html.twig', [
            'n' => $form,
        ]);
    }
    #[Route('/Editdelivery/{id}', name: 'Editdelivery')]
    public function Editdelivery(LivraisonRepository $livraisonRepository, ManagerRegistry $managerRegistry,Request $req,$id): Response
    {
        $t=$managerRegistry->getManager();
        $s=$livraisonRepository->find($id);
        $form = $this->createForm(LivraisonType::class,$s);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            $t->persist($s);
            $t->flush();
            return $this->redirectToRoute('Deliverylist');
        }
        return $this->renderForm('backend/Editdelivery.html.twig', [
            'c' => $form,
        ]);
    }
    #[Route('/DeleteDelivery/{id}', name: 'DeleteDelivery')]
    public function DeleteDelivery(LivraisonRepository $livraisonRepository, ManagerRegistry $managerRegistry,Request $req,$id): Response
    {
        $x=$managerRegistry->getManager();
        $a=$livraisonRepository->find($id);
        $x->remove($a);
        $x->flush();
        return $this->redirectToRoute('Deliverylist');
    }

}