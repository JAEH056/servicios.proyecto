<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class SolicitudesPracticasModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'solicitudes_practicas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';


    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_solicitud',
        'id_clase',
        'nombre_practica',
        'objetivo'
    ];
}