<?php

namespace App\Controller;

use App\Entity\Livraison;
// use App\Entity\User;
use App\Entity\LocalisationGeographique;
use App\Form\LivraisonType;
use App\Form\LocalisationGeographiqueType;
use App\Repository\LivraisonRepository;
use App\Repository\LocalisationGeographiqueRepository;
use Doctrine\Persistence\ManagerRegistry;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;
class BackendController extends AbstractController
{ 
    #[Route('/sms', name: 'sms')]
    public function sendSms(): Response
    {
        // Twilio account SID and auth token
        $sid    = 'ACb32b5dce2baf53ab832edbd2b8e8537a';
        $token  = '3c372c665a539c69b982fb690c44aef1';
// $user_numero=User.phone_number
        // Twilio phone number
        $twilio_number = '+1 240 339 2414';

        // Recipient's phone number
        $recipient_number = '+216 93 683 973';

        // Message body
        $message = 'Hello votre produit est sur commande. On vous contactera pour plus dinformation le plus tot possible.';

        // Create a new Twilio client
        $client = new Client($sid, $token);

        // Send the SMS message
        $client->messages->create(
            $recipient_number,
            [
                'from' => $twilio_number,
                'body' => $message
            ]
        );

        // Return a response to the client
        // return new Response('SMS sent successfully');
        return $this->render('delivery/sms.html.twig');
    }

    #[Route('/region-map', name: 'region_map')]
    public function regionMap(LocalisationGeographiqueRepository $localisationGeographiqueRepository): Response
    {
        $regionsData = $localisationGeographiqueRepository->getRegionsData();

        // Utilisation de la vue Twig pour rendre la page HTML
        return $this->render('backend/region_map.html.twig', [
            'regionsData' => $regionsData,
        ]);
    }
    
    #[Route('/Deliverylist', name: 'Deliverylist')]
    public function Deliverylist(LivraisonRepository $livraisonRepository): Response
    {
        $livraison=$livraisonRepository->findAll();
        return $this->render('backend/Deliverylist.html.twig', [
            'Livraison' => $livraison,
        ]);
    }
    #[Route('/pdfL', name: 'pdfL')]
    public function generatePdfl(): Response
    {
        // Récupérez les données à afficher dans le PDF (par exemple, depuis votre base de données)
        $location = $this->getDoctrine()->getRepository(LocalisationGeographique::class)->findAll();

        // Configurez Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        // Créez le HTML à partir du template Twig
        $html = $this->renderView('backend/pdfL.html.twig', [
            'location' => $location,
        ]);

        // Chargez le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Définissez les options du rendu PDF (par exemple, la taille du papier)
        $dompdf->setPaper('A4', 'landscape');

        // Rendez le PDF
        $dompdf->render();

        // Renvoyez la réponse avec le PDF généré
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }

    #[Route('/pdfD', name: 'pdfD')]
    public function generatePdf(): Response
    {
        // Récupérez les données à afficher dans le PDF (par exemple, depuis votre base de données)
        $livraisons = $this->getDoctrine()->getRepository(Livraison::class)->findAll();

        // Configurez Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        // Créez le HTML à partir du template Twig
        $html = $this->renderView('backend/pdfD.html.twig', [
            'Livraison' => $livraisons,
        ]);

        // Chargez le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Définissez les options du rendu PDF (par exemple, la taille du papier)
        $dompdf->setPaper('A4', 'landscape');

        // Rendez le PDF
        $dompdf->render();

        // Renvoyez la réponse avec le PDF généré
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
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
            'form' => $form,
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
            'form' => $form,
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
            'form' => $form,
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
            'form' => $form,
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