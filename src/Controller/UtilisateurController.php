<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUtilisateurType;
use App\Form\UserType;
use App\Repository\ProduitRepository;
use App\Repository\ServiceRepository;
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
    public function Home(ProduitRepository $produitRepository, ServiceRepository $serviceRepository): Response
    {
        $product=$produitRepository->findAll();
        $service=$serviceRepository->findAll();
        return $this->render('afterlogin/home.html.twig', [
            'table' => $product,
            'services' =>$service
        ]);
    }

    #[Route('/adminHome', name: 'adminHome')]
    public function adminHome(): Response
    {
        return $this->render('afterlogin/adminHome.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/Profile', name: 'Profile')]
    public function Profile(UserRepository $utilisateurRepository): Response
    {
        $user=$utilisateurRepository->findAll();
        return $this->render('afterlogin/profile.html.twig', [
            'table' => $user,
        ]);
    }

    #[Route('/editProfile', name: 'editProfile')]
    public function editProfile(UserRepository $userRepository, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$this->getUser();
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

    #[Route('/WhoItsFor', name: 'WhoItsFor')]
    public function WhoItsFor(): Response
    {
        return $this->render('afterlogin/whoitsfor.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
    #[Route('/HowToCraze', name: 'HowToCraze')]
    public function HowToCraze(): Response
    {
        return $this->render('afterlogin/howtocraze.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
    #[Route('/WhereWeBarter', name: 'WhereWeBarter')]
    public function WhereWeBarter(): Response
    {
        return $this->render('afterlogin/wherewebarter.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

}
