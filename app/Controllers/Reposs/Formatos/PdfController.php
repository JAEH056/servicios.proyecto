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
        $html = view('Reposs/Formatos/pfd_figma', $data);

        // Initialize DOMPDF
        
        $this->options->set('defaultFont', 'Arial');
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
}