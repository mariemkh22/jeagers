<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Notification;
use App\Form\MessageType;
use App\Form\NotificationType;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
class DashboardController extends AbstractController
{
    #[Route('/index', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    #[Route('/chat', name: 'chat')]
    public function chat(): Response
    {
        return $this->render('dashboard/chat.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    
    #[Route('/notiflist', name: 'notiflist')]
    public function notiflist(NotificationRepository $notificationRepository): Response
    {   $notif=$notificationRepository->findAll();
        return $this->render('dashboard/notiflist.html.twig', [
            'table' => $notif,
        ]);
    
    }
#[Route('/addnotif', name: 'addnotif')]
    public function addnotif(ManagerRegistry $managerRegistry,Request $req): Response

    {  
        $em=$managerRegistry->getManager();
        $nt=new Notification();
        $form=$this->createForm(NotificationType::class,$nt);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form ->isValid()){
            $em->persist($nt);
            $em->flush();
            return $this->redirectToRoute('notiflist');
        }
        
    
    return $this->render('dashboard/addnotif.html.twig', [
        'f'=>$form->createView()

        ]);
    }
    #[Route('/editnotif/{id}', name: 'editnotif')]
    public function editnotif($id,NotificationRepository $notificationRepository ,Request $req,ManagerRegistry $ManagerRegistry): Response
    {
        $em = $ManagerRegistry->getManager();
    // var_dump($id).die();
    $dataid=$notificationRepository->find($id);
    //var_dump($dataid).die();
    $form=$this->createForm(NotificationType::class,$dataid);
    $form->handleRequest($req);
    if($form->isSubmitted() and $form->isValid()){
        $em->persist($dataid);
        $em->flush();
        return $this->redirectToRoute('notiflist');

    }

    return $this->render('dashboard/editnotif.html.twig', [
        'x'=>$form->createView()
        


    ]);
    }
    #[Route('/deletenotif/{id}', name: 'deletenotif')]
    public function deletenotif($id,NotificationRepository $notificationRepository ,Request $req,ManagerRegistry $ManagerRegistry): Response
    {
        $em = $ManagerRegistry->getManager();
    // var_dump($id).die();
    $dataid=$notificationRepository->find($id);
    //var_dump($dataid).die();
   
    
    
        $em->remove($dataid);
        $em->flush();
        return $this->redirectToRoute('notiflist');

    

    
       
        


    
    
}
}

