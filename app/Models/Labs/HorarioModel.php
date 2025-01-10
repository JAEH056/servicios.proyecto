<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class HorarioModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'horario';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_semestre', 'id_laboratorio'];



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



    public function obtenerSolicitudesPorLaboratorio($idLaboratorio)
    {
        // Condiciones globales
        $globalConditions = [
            'laboratorio.id' => $idLaboratorio,
            'semestre.estado' => 1
        ];

        // Primera consulta (solicitudes prácticas)
        $builderPracticas = $this->db->table('horario')
            ->select("
            solicitud.id AS solicitud_id,
            solicitud.hora_fecha_entrada AS fecha_hora_entrada,
            solicitud.hora_fecha_salida AS fecha_hora_salida,
            solicitud.fecha_envio,
            solicitudes_practicas.nombre_practica AS titulo,
            asignatura.clave AS clave_asignatura,
            grupo.nombre AS grupo,
            usuario.principal_name AS correo
        ")
            ->join('semestre', 'semestre.id = horario.id_semestre')
            ->join('laboratorio', 'laboratorio.id = horario.id_laboratorio')
            ->join('solicitud', 'solicitud.id_laboratorio = laboratorio.id')
            ->join('solicitudes_practicas', 'solicitudes_practicas.id_solicitud = solicitud.id')
            ->join('clase', 'clase.id = solicitudes_practicas.id_clase')
            ->join('reticula', 'reticula.id_carrera = clase.id_carrera AND reticula.id_asignatura = clase.id_asignatura')
            ->join('carrera', 'carrera.id = reticula.id_carrera')
            ->join('asignatura', 'asignatura.id = reticula.id_asignatura')
            ->join('grupo', 'grupo.id = clase.id_grupo')
            ->join('db_compartida.puesto_empleado', 'puesto_empleado.idpuesto = solicitud.id_puesto_empleado')
            ->join('db_compartida.usuario', 'usuario.idusuario = puesto_empleado.idusuario')
            ->where($globalConditions);

        // Segunda consulta (solicitudes varias)
        $builderVarias = $this->db->table('horario')
            ->select("
            solicitud.id AS solicitud_id,
            solicitud.hora_fecha_entrada AS fecha_hora_entrada,
            solicitud.hora_fecha_salida AS fecha_hora_salida,
            solicitud.fecha_envio,
            solicitudes_varias.nombre_proyecto AS titulo,
            '' AS clave_asignatura,
            '' AS grupo,
            usuario.principal_name AS correo
        ")
            ->join('semestre', 'semestre.id = horario.id_semestre')
            ->join('laboratorio', 'laboratorio.id = horario.id_laboratorio')
            ->join('solicitud', 'solicitud.id_laboratorio = laboratorio.id')
            ->join('solicitudes_varias', 'solicitudes_varias.id_solicitud = solicitud.id')
            ->join('tipo_uso', 'tipo_uso.id = solicitudes_varias.id_tipo_uso')
            ->join('db_compartida.puesto_empleado', 'puesto_empleado.idpuesto = solicitud.id_puesto_empleado')
            ->join('db_compartida.usuario', 'usuario.idusuario = puesto_empleado.idusuario')
            ->where($globalConditions);

        // Combinar las consultas con UNION y ordenar por fecha_envio
        $query = $this->db->query(
            $builderPracticas->getCompiledSelect() .
                ' UNION ' .
                $builderVarias->getCompiledSelect() .
                ' ORDER BY fecha_envio ASC'
        );

        // Retornar resultados como un array
        return $query->getResultArray();
    }
}
