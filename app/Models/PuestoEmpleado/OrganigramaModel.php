<?php

namespace App\Models\PuestoEmpleado;

use CodeIgniter\Model;

class OrganigramaModel extends Model
{
    protected $DBGroup = 'compartida';
    protected $table = 'organigrama';
    protected $primaryKey = 'idorganigrama';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nombreM', 'nombreF', 'cargo', 'izquierda', 'derecha'];

   
}

