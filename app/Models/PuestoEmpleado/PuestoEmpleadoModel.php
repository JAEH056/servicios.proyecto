<?php

namespace App\Models\PuestoEmpleado;

use CodeIgniter\Model;

class PuestoEmpleadoModel extends Model
{
    protected $DBGroup = 'compartida';
    protected $table = 'puesto_empleado';
    protected $primaryKey = 'idpuesto';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['idusuario', 'idorganigrama', 'fecha_inicio', 'fecha_fin'];

    
    public function AsignarPuesto($data)
    {
        return $this->insert($data);

    }
    public function puestoAsignadoPorUsuario($userId)
    {
        return $this->where('idusuario', $userId)
                    ->where('fecha_fin', null)  // Verificar que la fecha_fin sea NULL (puesto activo)
                    ->first();  // Retorna el primer resultado (si existe)
    }
}
