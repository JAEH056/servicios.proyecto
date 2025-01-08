<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class HorarioModel extends Model
{
    protected $DBGroup = 'laboratorios';  // Base de datos para 'laboratorios'
    protected $table      = 'horario';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_semestre', 'id_laboratorio'];


    // Método para obtener horarios por laboratorio
    public function obtenerHorariosPorLaboratorio($idLaboratorio): array
    {
        $builder = $this->db->table('horario')
            ->select('semestre.id AS semestre_id, laboratorio.id AS laboratorio_id,
                  semestre.inicio AS inicio,
                  semestre.fin AS fin,
                  laboratorio.nombre AS nombre_laboratorio,
                  carrera.nombre AS nombre_carrera')
            ->join('semestre', 'semestre.id = horario.id_semestre')
            ->join('laboratorio', 'laboratorio.id = horario.id_laboratorio')
            ->join('carrera', 'carrera.id = laboratorio.id_carrera')
            ->where('horario.id_laboratorio', $idLaboratorio)
            ->where('semestre.estado', 1);

        $query = $builder->get();
        $horarioLab = $query->getResultArray();
        return $horarioLab;
    }

    // Método para obtener solicitudes por horario
    public function obtenerSolicitudesPorLaboratorio($idLaboratorio)
    {
        // Definir las columnas necesarias en la selección
        $builder = $this->db->table('horario')
            ->select('
                solicitud.hora_fecha_entrada AS fecha_hora_entrada,
                solicitud.hora_fecha_salida AS fecha_hora_salida,
                solicitud.fecha_envio AS fechaDeEnvio,
                solicitudes_varias.nombre_proyecto AS nombreproyecto,
                tipo_uso.nombre AS tipo_uso,
                solicitudes_varias.descripcion_tareas,
                usuario.principal_name AS correo'
            )
            
            ->join('semestre', 'semestre.id = horario.id_semestre')
            ->join('laboratorio', 'laboratorio.id = horario.id_laboratorio')
            ->join('solicitud', 'solicitud.id_laboratorio = laboratorio.id')
            ->join('solicitudes_varias', 'solicitudes_varias.id_solicitud = solicitud.id')
            ->join('tipo_uso', 'tipo_uso.id = solicitudes_varias.id_tipo_uso')
            
            
            ->join('db_compartida.puesto_empleado', 'puesto_empleado.idpuesto = solicitud.id_puesto_empleado', 'left')  // LEFT JOIN por si no hay datos en puesto_empleado
            ->join('db_compartida.usuario', 'usuario.idusuario = puesto_empleado.idusuario', 'left')  // LEFT JOIN por si no hay datos en usuario
            
            
            ->where('laboratorio.id', $idLaboratorio)
            ->where('semestre.estado', 1)
            
            
            ->orderBy('solicitud.fecha_envio', 'ASC');
        
       
        $query = $builder->get();
        
      
        return $query->getResultArray();
    }
    
}
