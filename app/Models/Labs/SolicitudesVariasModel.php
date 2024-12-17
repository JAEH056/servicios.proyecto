<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class SolicitudesVariasModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'solicitude_varias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';


    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_solicitud',
        'id_tipo_uso',
        'descripcion_tareas',
        'nombre_proyecto'
    ];
}
