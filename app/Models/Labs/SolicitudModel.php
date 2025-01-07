<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class SolicitudModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'solicitud';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Dates
    protected $useTimestamps = false;
    protected $createdField  = 'fecha_envio';
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = [
        'id_laboratorio',
        'id_puesto_empleado',
        'hora_fecha_entrada',
        'hora_fecha_salida',
        'fecha_envio',
        
    ];

    
}
