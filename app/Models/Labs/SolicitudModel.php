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
    protected $allowedFields = ['hora_fecha_entrada', 'hora_fecha_salida', 'id_laboratorio'];
}
