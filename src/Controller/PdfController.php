<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PdfController extends AbstractController
{
    public function generatePdf(): Response
    {
        // Render Twig template
        $html = $this->renderView('backend/commandePDF.html.twig', [
            // Pass any necessary data to the Twig template
        ]);

        // Instantiate Dompdf
        $dompdf = new Dompdf();

        // Load HTML content
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Output PDF as response
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Commande_list.pdf"',
        ]);
    }
}