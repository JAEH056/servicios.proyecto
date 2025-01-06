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
    protected $allowedFields = ['idpuesto', 'idusuario', 'idorganigrama', 'fecha_inicio', 'fecha_fin'];


    public function AsignarPuesto($data)
    {
        return $this->insert($data);
    }
    public function puestoAsignadoPorUsuario($userId, \DateTimeImmutable $fecha_actual = null)
    {
        //$fecha_actual = !is_null($fecha_actual) ? $fecha_actual : new \DateTimeImmutable();
        $fecha_actual = $fecha_actual ?? new \DateTimeImmutable();
        $fecha_actualStr = $fecha_actual->format('Y-m-d');


        $builder = $this->db->table($this->table)
            ->select('organigrama.cargo')
            ->join('organigrama', 'organigrama.idorganigrama=puesto_empleado.idorganigrama')
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

    public function puestoUsuario(int $userId)
    {
        //Busca el primer puesto(actual) de mayor rango que tenga el usuario
        $result = $this->select('puesto_empleado.idpuesto')
            ->where('idusuario', $userId)
            ->where('fecha_fin', null)
            ->orderBy('idorganigrama', 'ASC')
            ->first();
        // Verifica si se encontró un resultado
        if ($result) {
            // Convierte el idpuesto a entero y lo devuelve
            return intval($result['idpuesto']);
        }
        return null;
    }

    public function buscarDocenteBy($nombreDocente){
    return $this->select('us.principal_name, us.nombre, us.apellido1, us.apellido2, og.nombreM, og.cargo')
             ->join('db_compartida.usuario us', 'puesto_empleado.idusuario = us.idusuario')
             ->join('db_compartida.organigrama og', 'puesto_empleado.idorganigrama = og.idorganigrama')
             ->where('puesto_empleado.fecha_fin', null)
             ->where('og.cargo', 'Docente')
             ->where('us.nombre', $nombreDocente)
             ->get()
             ->getResultArray();
    }
}
