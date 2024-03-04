<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Form\CommandeType;
use App\Form\EditCommandeType;
use App\Form\EditProduitType;
use App\Form\ProduitType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class BackendController extends AbstractController
{
    #[Route('/backendhome', name: 'backendhome')]
    public function backendhome(): Response
    {
        return $this->render('backend/backendhome.html.twig', [
            'controller_name' => 'BackendController',
        ]);
    }

    #[Route('/displayProducts', name: 'displayProducts')]
    public function displayProducts(ProduitRepository $ProduitRepository): Response
    {
        $produit=$ProduitRepository->findAll();
        return $this->render('backend/ProductList.html.twig', [
            'table' => $produit
        ]);
    }
    


    
    #[Route('/addProduct', name: 'addProduct')]
    public function addProduct(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $entityManager = $managerRegistry->getManager();
        
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image file for each product
            $imageFile = $form['imageFile']->getData();

            if ($imageFile) {
                // Handle the upload with VichUploaderBundle
                // For example, if you're using VichUploaderBundle:
                // $produit->setImageFile($imageFile);
                // $entityManager->persist($produit);
                // $entityManager->flush();
            }

            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('displayProducts');
        }

        return $this->render('backend/addProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }






    #[Route('/edit/{id}', name: 'edit')]
    public function edit(ProduitRepository $produitRepository, ManagerRegistry $managerRegistry, Request $request, $id):Response
    {
        $entityManager = $managerRegistry->getManager();
        $produit = $produitRepository->find($id);

        if (!$produit) {
            throw $this->createNotFoundException('Product not found');
        }

        $form = $this->createForm(EditProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image file for the product
            $imageFile = $form['imageFile']->getData();

            if ($imageFile) {
                // Handle the upload with VichUploaderBundle
                // For example, if you're using VichUploaderBundle:
                // $produit->setImageFile($imageFile);
            }

            $entityManager->flush();

            return $this->redirectToRoute('displayProducts');
        }

        return $this->render('backend/editProductbyid.html.twig', [
            'form' => $form->createView()
        ]);
    }








    #[Route('/delete/{id}', name: 'delete')]
    public function delete(ProduitRepository $ProduitRepository, ManagerRegistry $managerRegistry, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$ProduitRepository->find($id);
        $m->remove($findid);
        $m->flush();
        return $this->redirectToRoute('displayProducts');
    }






#backendCommande
    #[Route('/displayComd', name: 'displayComd')]
    public function displayComd(CommandeRepository $CommandeRepository): Response
    {
        $cmd=$CommandeRepository->findAll();
        return $this->render('backend/CommandeList.html.twig', [
            'table' => $cmd
        ]);
    }





    #[Route('/generatePdf', name: 'generatePdf')]
    public function generatePdf(CommandeRepository $commandeRepository): Response
    {
       
        $options = new Options();
        // Set Dompdf options
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isFontSubsettingEnabled', true);
        $options->set('pdfBackend', 'CPDF');
        $options->set('defaultPaperSize', 'A4'); 
        $options->set('defaultPaperOrientation', 'portrait'); 
        $options->set('dpi', 150); 
        $options->set('fontHeightRatio', 1.1); 
        $options->set('margin-top', 20); 
        $options->set('margin-right', 15); 
        $options->set('margin-bottom', 20); 
        $options->set('margin-left', 15); 
        $commands = $commandeRepository->findAll();
    
       
        $dompdf = new Dompdf($options);
        
        // Configure Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf->setOptions($options);
    
        // Generate PDF content
        $html = $this->renderView('backend/commandePDF.html.twig', [
            'table' => $commands,
        ]);
    
        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);
    
        // Render PDF
        $dompdf->render();
    
        // Output PDF
        $output = $dompdf->output();
    
        // Return PDF as response
        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }







    #[Route('/addComd', name: 'addComd')]
    public function addComd(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $cmd=new Commande();
        $form=$this->createForm(CommandeType::class,$cmd);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($cmd);
            $m->flush();

            return $this->redirectToRoute('displayComd');
        }
        return $this->render('backend/addCommande.html.twig', [
            'form' => $form->createView()
        ]);
    }
  
    #[Route('/editc/{id}', name: 'editc')]
    public function editc(CommandeRepository $CommandeRepository, ManagerRegistry $managerRegistry, Request $request, $id):Response
    {
        $m=$managerRegistry->getManager();
        $findid=$CommandeRepository->find($id);
        $form=$this->createForm(EditCommandeType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('displayComd');
        }
        return $this->render('backend/editCommandebyid.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/deletec/{id}', name: 'deletec')]
    public function deletec(CommandeRepository $CommandeRepository, ManagerRegistry $managerRegistry, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$CommandeRepository->find($id);
        $m->remove($findid);
        $m->flush();
        return $this->redirectToRoute('displayComd');
    }
}