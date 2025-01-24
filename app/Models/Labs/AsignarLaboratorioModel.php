<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class AsignarLaboratorioModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'asignar_laboratorio';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_puesto_empleado','id_laboratorio','inicio','fin'];

    public function obtenerLaboratorioPorEncargado($id_usuario, \DateTimeImmutable $fecha_actual = null)
    {
        // Si no se pasa una fecha, usar la fecha actual
        $fecha_actual = !is_null($fecha_actual) ? $fecha_actual : new \DateTimeImmutable();
        $fecha_actualStr = $fecha_actual->format('Y-m-d');

        // Construir la consulta con el builder
        $builder = $this->db->table($this->table)
            ->select('laboratorio.id AS id_laboratorio, laboratorio.nombre AS nombre_laboratorio, 
                  asignar_laboratorio.inicio AS inicio, 
                  asignar_laboratorio.fin AS fin, 
                  GROUP_CONCAT(CONCAT(usuario.nombre, " ", usuario.apellido1, " ", usuario.apellido2) 
                  ORDER BY usuario.id ASC) AS encargado')
            ->join('laboratorio', 'asignar_laboratorio.id_laboratorio = laboratorio.id')
            ->join('usuario', 'asignar_laboratorio.id_usuario = usuario.id')
            ->where('usuario.id', $id_usuario)
            ->where('asignar_laboratorio.inicio <=', $fecha_actualStr)
            ->groupStart()
            ->where('asignar_laboratorio.fin IS NULL')
            ->orWhere('asignar_laboratorio.fin >=', $fecha_actualStr)
            ->groupEnd()
            ->groupBy('laboratorio.id');

        // Ejecutar la consulta
        $query = $builder->get();
        $laboratoriosAsignados = $query->getResultArray();


        return $laboratoriosAsignados;
    }
    public function obtenerEncargadoDeLaboratorio(int $userId,\DateTimeImmutable $fecha_actual = null) {
        $fecha_actual = $fecha_actual ?? new \DateTimeImmutable();
        $fecha_actualStr = $fecha_actual->format('Y-m-d');
        $builder = $this->db->table($this->table)
        ->select('asignar_laboratorio.id AS id_asignar_laboratorio,
                  puesto_empleado.idpuesto AS id_puesto,
                  organigrama.cargo AS cargo')
        ->join('compartida.puesto_empleado','puesto_empleado.idpuesto = asignar_laboratorio.id_puesto_empleado')
        ->join('compartida.organigrama', 'organigrama.idorganigrama = puesto_empleado.idorganigrama')
        ->join('compartida.usuario', 'usuario.idusuario = puesto_empleado.idusuario')
        ->where('usuario.idusuario =',$userId);
        $query= $builder->get();
        return  $query->getResultArray();
    }
}
