<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class AutorizacionModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'autorizacion';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType   = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_asignar_laboratorio',
        'id_solicitud',
        'estado',
        'observacion'
    ];
    
}
