<?php

namespace App\Controllers\Reposs;

use CodeIgniter\Config\BaseConfig;

class RutaDocumentos extends BaseConfig
{
    // Ruta personalizada para guardar los archivos
    public $uploadPath = WRITEPATH . 'uploads/documents';  // Puedes personalizar esta ruta
}
