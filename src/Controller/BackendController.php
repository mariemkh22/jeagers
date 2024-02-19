<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Utilisateur;
use App\Form\EditUtilisateurType;
use App\Form\UtilisateurAuthorType;
use App\Repository\UserRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackendController extends AbstractController
{
    #[Route('/backendHome', name: 'backendHome')]
    public function backendHome(): Response
    {
        return $this->render('backend/backendhome.html.twig', [
            'controller_name' => 'BackendController',
        ]);
    }

    #Backend CRUD

    #[Route('/displayUsers', name: 'displayUsers')]
    public function displayUsers(UserRepository $utilisateurRepository): Response
    {
        $user=$utilisateurRepository->findAll();
        return $this->render('backend/UsersList.html.twig', [
            'table' => $user
        ]);
    }

    #[Route('/addUser', name: 'addUser')]
    public function addUser(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $user=new User();
        $form=$this->createForm(UtilisateurAuthorType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($user);
            $m->flush();

            return $this->redirectToRoute('displayUsers');
        }
        return $this->render('backend/addUser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(UserRepository $utilisateurRepository, ManagerRegistry $managerRegistry, Request $request, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$utilisateurRepository->find($id);
        $form=$this->createForm(EditUtilisateurType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('displayUsers');
        }
        return $this->render('backend/edituserbyid.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(UserRepository $utilisateurRepository, ManagerRegistry $managerRegistry, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$utilisateurRepository->find($id);
        $m->remove($findid);
        $m->flush();
        return $this->redirectToRoute('displayUsers');
    }

}
