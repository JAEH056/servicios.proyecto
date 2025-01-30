<?php

namespace App\Controllers\Reposs\Formatos;

use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends Controller
{
    protected $options;

    public function __construct()
    {
        $this->options = new Options();
    }
    public function generar()
    {
        // Load your view file and pass data if needed
        $data = [
            'title' => 'My PDF Document',
            'content' => 'This is a sample PDF generated using DOMPDF in CodeIgniter.'
        ];

        // Render the view to a string
        $html = view('Reposs/Formatos/solicitud_residencias', $data);

        // Initialize DOMPDF
        //$this->options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($this->options);

        // Load HTML content
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('letter', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('document.pdf', ['Attachment' => false]);
    }

    public function generateSolicitudPDF()
    {
        // Cargar la vista con los datos necesarios
        $html = view('Reposs/Formatos/solicitud_residencias');

        // Configurar DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // Establecer el tamaño de papel a carta (8.5 x 11 pulgadas)
        $dompdf->setPaper('letter', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Enviar el PDF al navegador
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="solicitud_residencias.pdf"')
            ->setBody($dompdf->output());
    }
}