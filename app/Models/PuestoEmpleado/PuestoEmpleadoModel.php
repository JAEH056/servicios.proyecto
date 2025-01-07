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
    public function puestoAsignadoPorUsuario($userId,\DateTimeImmutable $fecha_actual = null)
    {
        //$fecha_actual = !is_null($fecha_actual) ? $fecha_actual : new \DateTimeImmutable();
        $fecha_actual = $fecha_actual ?? new \DateTimeImmutable();
        $fecha_actualStr = $fecha_actual->format('Y-m-d');

        
        $builder = $this->db->table($this->table)
        ->select('
            puesto_empleado.idpuesto AS idpuesto, organigrama.cargo')
        ->join('organigrama','organigrama.idorganigrama=puesto_empleado.idorganigrama')
        ->where('idusuario', $userId)
        ->groupStart() 
            ->where('fecha_inicio <=', $fecha_actualStr)
            ->where('fecha_fin IS NULL')
        ->groupEnd()  
        ->orGroupStart() 
            ->where('fecha_fin >=', $fecha_actualStr)
        ->groupEnd();  
        $query = $builder->get();
        $puestoempleado = $query->getRowArray();
        return $puestoempleado;

    }
}
