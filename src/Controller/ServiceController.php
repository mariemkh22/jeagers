<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\SerFrontType;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ServiceType;
use App\Form\UpdateFormType;
use Knp\Component\Pager\PaginatorInterface;
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
    public function services(ServiceRepository $repo): Response
    {
        $ser = $repo->findAll();
        return $this->render('service/services.html.twig', [
            'services' => $ser,
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
    public function displayS(ServiceRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $ser = $repo->findAll();
        
        $ser= $paginator->paginate(
            $ser, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );
        
    return $this->render('service/services.html.twig', [
            'services' => $ser,
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



#[Route('/myservices', name: 'myservices')]
public function myservices(ServiceRepository $repo, PaginatorInterface $paginator, Request $request ): Response
{
    $ser = $repo->findAll();
    
    $ser= $paginator->paginate(
        $ser, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        2 /*limit per page*/
    );
    
    return $this->render('service/myservices.html.twig', [
        'services' => $ser,
    ]);
}

#[Route('/editS/{id}', name: 'editS')]
    public function editS(ServiceRepository $serviceRepository, ManagerRegistry $managerRegistry, Request $request, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$serviceRepository->find($id);
        $form=$this->createForm(UpdateFormType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('myservices');
        }
        return $this->render('service/editmyservices.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/deletemyServices/{id}',name:'deletemyServices')]
    public function deletemyServices( $id , ManagerRegistry $manager, ServiceRepository $repo):Response{
        $service=$repo->find($id) ;  
        $em= $manager->getManager();
        $em->remove($service);
        $em->flush();
        return $this->redirectToRoute("myservices");
    }
}
