<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\SerFrontType;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'service')]
    public function service(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
   
    #[Route('/services', name: 'services')]
    public function services(): Response
    {
        return $this->render('service/services.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    #[Route('/addService', name: 'addService')]
    public function addService(): Response
    {
        return $this->render('service/addService.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
    
    #[Route('/editServicesfront', name: 'editServicesfront')]
    public function editServicesfront(): Response
    {
        return $this->render('service/editServicesfront.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    #[Route('/displayS', name: 'displayS')]
    public function displayS(ServiceRepository $repo): Response
    {
        
        $ser = $repo->findAll();
        return $this->render('service/services.html.twig', [
            'services' => $ser
        ]);
    }
    #[Route('/addServic', name: 'addServic')]  
public function addServic(Request $req, ManagerRegistry $manager):Response{
    $ser = new Service();
    $form = $this->createForm(SerFrontType::class, $ser);
    $form->handleRequest($req);
    $em = $manager->getManager();
    if($form->isSubmitted() and $form->isValid()){
    $em->persist($ser);
    $em->flush();
    return $this->redirectToRoute("displayS");
}
return $this->renderForm('service/addService.html.twig', ['form'=>$form]);}



    




    






}
