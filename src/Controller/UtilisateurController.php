<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUtilisateurType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateurHome', name: 'utilisateurHome')]
    public function utilisateurHome(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
    
    #[Route('/utilisateurWhoItsFor', name: 'utilisateurWhoItsFor')]
    public function utilisateurWhoItsFor(): Response
    {
        return $this->render('utilisateur/whoitsfor.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
    #[Route('/utilisateurHowToCraze', name: 'utilisateurHowToCraze')]
    public function utilisateurHowToCraze(): Response
    {
        return $this->render('utilisateur/howtocraze.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
    #[Route('/utilisateurWhereWeBarter', name: 'utilisateurWhereWeBarter')]
    public function utilisateurWhereWeBarter(): Response
    {
        return $this->render('utilisateur/wherewebarter.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
    #[Route('/utilisateurLogIn', name: 'utilisateurLogIn')]
    public function utilisateurLohgIn(): Response
    {
        return $this->render('utilisateur/login.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #After Log in

    #[Route('/Home', name: 'Home')]
    public function Home(): Response
    {
        return $this->render('afterlogin/home.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/Profile', name: 'Profile')]
    public function Profile(): Response
    {
        return $this->render('afterlogin/profile.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/editProfile/{id}', name: 'editProfile')]
    public function editProfile(UserRepository $userRepository, ManagerRegistry $managerRegistry, Request $request, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$userRepository->find($id);
        $form=$this->createForm(EditUtilisateurType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('Profile');
        }
        return $this->render('afterlogin/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
