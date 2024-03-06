<?php

namespace App\Controller;

use App\Entity\CategorieService;
use App\Entity\Service;
use App\Form\CategorieServiceType;
use App\Form\ServiceType;
use App\Form\UpdateFormType;
use App\Repository\CategorieServiceRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;


class BackController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    #[Route('/serviceList', name: 'serviceList')]
    public function serviceList(): Response
    {
        return $this->render('back/serviceList.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    
    #[Route('/serviceDetails', name: 'serviceDetails')]
    public function serviceDetails(): Response
    {
        return $this->render('back/serviceDetails.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    #[Route('/addservice', name: 'addservice')]
    public function addservice(): Response
    {
        return $this->render('back/addservice.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    #[Route('/categorylist', name: 'categorylist')]
    public function categorylist(): Response
    {
        return $this->render('back/categorylist.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    #[Route('/addcategory', name: 'addcategory')]
    public function addcategory(): Response
    {
        return $this->render('back/addcategory.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    #[Route('/serviice', name: 'serviice')]
    public function serviice(): Response
    {
        return $this->render('back/serviice.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    #[Route('/editservice', name: 'editservice')]
    public function editservice(): Response
    {
        return $this->render('back/editservice.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    #[Route('/editcategory', name: 'editcategory')]
    public function editcategory(): Response
    {
        return $this->render('back/editcategory.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }

    #[Route('/showS', name: 'showS')]
    public function showS(ServiceRepository $repo): Response
    {
        
        $service = $repo->findAll();
        return $this->render('back/serviceList.html.twig', [
            'services' => $service
        ]);
    }

    #[Route('/addservices', name: 'addservices')]
    public function addservices(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $service=new Service();
        $form=$this->createForm(ServiceType::class,$service);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($service);
            $m->flush();
            return $this->redirectToRoute('showS');
        }
        return $this->render('back/addservice.html.twig', [
            'f' => $form->createView()
        ]);
    }

    #[Route('/updateS/{id}', name: 'updateS')]
    public function updateS(ServiceRepository $serviceRepository, ManagerRegistry $managerRegistry, Request $request, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$serviceRepository->find($id);
        $form=$this->createForm(UpdateFormType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('showS');
        }
        return $this->render('back/editservice.html.twig', [
            'f' => $form->createView()
        ]);
    }
    #[Route('/deleteService/{id}',name:'deleteService')]
    public function deleteService( $id , ManagerRegistry $manager, ServiceRepository $repo):Response{
        $service=$repo->find($id) ;  
        $em= $manager->getManager();
        $em->remove($service);
        $em->flush();
        return $this->redirectToRoute("showS");
    }

    #[Route('/showC', name: 'showC')]
    public function showC(CategorieServiceRepository $repo): Response
    {
        
        $cat = $repo->findAll();
        return $this->render('back/categorylist.html.twig', [
            'categories' => $cat
        ]);
    }

    #[Route('/addcategories', name: 'addcategories')]
    public function addcategories(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $cat=new CategorieService();
        $form=$this->createForm(CategorieServiceType::class,$cat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($cat);
            $m->flush();
            return $this->redirectToRoute('showC');
        }
        return $this->render('back/addcategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/updateC/{id}', name: 'updateC')]
    public function updateC(CategorieServiceRepository $serviceRepository, ManagerRegistry $managerRegistry, Request $request, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$serviceRepository->find($id);
        $form=$this->createForm(CategorieServiceType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('showC');
        }
        return $this->render('back/editcategory.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/deleteCategory/{id}',name:'deleteCategory')]
    public function deleteCategory( $id , ManagerRegistry $manager, CategorieServiceRepository $repo):Response{
        $cat=$repo->find($id) ;  
        $em= $manager->getManager();
        $em->remove($cat);
        $em->flush();
        return $this->redirectToRoute("showC");
    }

    // ContratController.php
#[Route('/stats', name: 'app_mon_stats')]
public function contratStats(CategorieServiceRepository $repo): Response
{
    // Récupérez les données des contrats depuis votre base de données
    $cat = $repo->findAll();

    // Initialisez un tableau pour stocker les statistiques des categories
    $stats = [
        'Educational barter' => 0,
        'DIY services' => 0,
        'Health and wellness services' => 0,
        'Cleaning services' => 0,
        'Sports services' => 0,
        'Entertainment services' => 0,
        'Transportation services' => 0,
        'Other services' => 0,
        // Ajoutez d'autres cat si nécessaire
    ];

    // Calculez les statistiques des contrats
    foreach ($cat as $cat) {
        $nameC = $cat->getNameC();

        // Vérifiez si la clé existe dans le tableau $stats
        if (array_key_exists($nameC, $stats)) {
            $stats[$nameC]++;
        } else {
            // Si la clé n'existe pas, vous pouvez choisir de l'ignorer ou de la gérer d'une autre manière
            // Ici, nous ajoutons le statut inconnu dans le tableau $stats avec une valeur de 1
            $stats[$nameC] = 1;
        }
    }
   

    // Créez le Pie Chart
    $pieChart = new PieChart();
    $pieChart->getData()->setArrayToDataTable([
        ['nameC', 'Nombre de categories'],
        ['Educational barter', $stats['Educational barter']],
        ['DIY services', $stats['DIY services']],
        ['Health and wellness services', $stats['Health and wellness services']],
        ['Cleaning services', $stats['Cleaning services']],
        ['Sports services', $stats['Sports services']],
        ['Entertainment services', $stats['Entertainment services']],
        ['Transportation services', $stats['Transportation services']],
        ['Other services', $stats['Other services']],


    
        // Ajoutez d'autres statuts si nécessaire
    ]);
    $pieChart->getOptions()->setTitle('Distribution of categories by name');

    // Renvoyez la vue avec le Pie Chart
    return $this->render('back/statst.html.twig', [
        'pieChart' => $pieChart,
        'stats' => $stats,
    ]);
}








    

    
    

    






}
