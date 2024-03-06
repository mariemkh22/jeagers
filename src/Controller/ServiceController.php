<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\SerFrontType;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ServiceType;
use App\Form\UpdateFormType;
use App\Repository\CalendarRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;


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
            6 /*limit per page*/
        );
        $someInteger = 3;
        return $this->render('service/services.html.twig', [
            'services' => $ser,
            'someInteger' => $someInteger,
    
        ]);
    }
    
    
     
    #[Route('/searchServices', name: 'searchServices')]
public function getServicesByLocationAndCategory(ServiceRepository $serviceRepository, $location, $categoryName): Response
{
    $services = $serviceRepository->findServicesByLocationAndCategory($location, $categoryName);

    return $this->render('service/recherche_service.html.twig', [
        'services' => $services,
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
public function myservices(ServiceRepository $repo, PaginatorInterface $paginator, Request $request): Response
{
    $serv = $repo->findAll();
    $serv= $paginator->paginate(
        $serv, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        3 /*limit per page*/
    );

    

    
    return $this->render('service/myservices.html.twig', [
        'services' => $serv,

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

    #[Route('/statstic', name: 'app_mon_statstic')]
public function serviceStats(ServiceRepository $repo): Response
{
    // Récupérez les données des services depuis votre base de données
    $ser = $repo->findAll();

    // Initialisez un tableau pour stocker les statistiques des services
    $stats = [
        'Gabes' => 0,
        'Monastir' => 0,
        'Tunis' => 0,
        'Nabeul' => 0,
        'Kebilli' => 0,
        'Sousse' => 0,
        'Bizerte' => 0,
        'Sfax' => 0,
        // Ajoutez d'autres services si nécessaire
    ];

    // Calculez les statistiques des contrats
    foreach ($ser as $ser) {
        $localisation = $ser->getLocalisation();

        // Vérifiez si la clé existe dans le tableau $stats
        if (array_key_exists($localisation, $stats)) {
            $stats[$localisation]++;
        } else {
            // Si la clé n'existe pas, vous pouvez choisir de l'ignorer ou de la gérer d'une autre manière
            // Ici, nous ajoutons le statut inconnu dans le tableau $stats avec une valeur de 1
            $stats[$localisation] = 1;
        }
    }
   

    // Créez le Pie Chart
    $pieChart = new PieChart();
    $pieChart->getData()->setArrayToDataTable([
        ['localisation', 'Nombre de services'],
        ['Gabes', $stats['Gabes']],
        ['Monastir', $stats['Monastir']],
        ['Tunis', $stats['Tunis']],
        ['Nabeul', $stats['Nabeul']],
        ['Kebilli', $stats['Kebilli']],
        ['Sousse', $stats['Sousse']],
        ['Bizerte', $stats['Bizerte']],
        ['Sfax', $stats['Sfax']],


    
        // Ajoutez d'autres statuts si nécessaire
    ]);
    $pieChart->getOptions()->setTitle('Distribution of services by location');

    // Renvoyez la vue avec le Pie Chart
    return $this->render('service/statistic.html.twig', [
        'pieChart' => $pieChart,
        'stats' => $stats,
    ]);

    

    
}

#[Route('/calendrier', name: 'calendrier')]
    public function calendrier(CalendarRepository $calendar): Response
    {
        $events = $calendar->findAll();
        
        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->isAllDay(),

            ];
        }

        $data = json_encode($rdvs);
       
        return $this->render('service/fullcalendar.html.twig', compact('data')); 
       
    } 

}