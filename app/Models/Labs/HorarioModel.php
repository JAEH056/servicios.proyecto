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
        $sql = <<<EOL

            SELECT 
                solicitud.id AS solicitud_id,
                solicitud.hora_fecha_entrada AS fecha_hora_entrada,
                solicitud.hora_fecha_salida AS fecha_hora_salida, 
                solicitud.fecha_envio,
                solicitudes_practicas.nombre_practica AS titulo,
                solicitudes_practicas.objetivo AS objetivo,
                carrera.nombre AS carrera ,
                asignatura.clave AS clave_asignatura ,
                grupo.nombre AS grupo,
                '' AS tipo_uso_varias,
                '' AS descripcion_tareas,
                usuario.principal_name AS correo,
                autorizacion.estado As estado
        FROM horario
        JOIN semestre ON semestre.id = horario.id_semestre    
        JOIN laboratorio ON laboratorio.id = horario.id_laboratorio
        JOIN solicitud ON solicitud.id_laboratorio = laboratorio.id
        JOIN solicitudes_practicas ON solicitudes_practicas.id_solicitud = solicitud.id  
        JOIN clase ON clase.id = solicitudes_practicas.id_clase
        JOIN reticula ON reticula.id_carrera = clase.id_carrera AND reticula.id_asignatura = clase.id_asignatura
        JOIN carrera ON carrera.id = reticula.id_carrera
        JOIN asignatura ON asignatura.id = reticula.id_asignatura
        JOIN grupo ON grupo.id = clase.id_grupo
        JOIN db_compartida.puesto_empleado on db_compartida.puesto_empleado.idpuesto= solicitud.id_puesto_empleado
        JOIN db_compartida.usuario on usuario.idusuario= puesto_empleado.idusuario
        JOIN autorizacion on autorizacion.id_solicitud = solicitud.id
        WHERE laboratorio.id= $idLaboratorio AND semestre.estado=1

        UNION 

        SELECT 
            solicitud.id AS solicitud_id,
            solicitud.hora_fecha_entrada AS fecha_hora_entrada,
            solicitud.hora_fecha_salida AS fecha_hora_salida,
            solicitud.fecha_envio,
            solicitudes_varias.nombre_proyecto AS titulo,
            ''AS objetivo,
            ''AS carrera,
            ''AS clave_asignatura,
            ''AS grupo,
            tipo_uso.nombre AS tipo_uso_varias,
            solicitudes_varias.descripcion_tareas AS  descripcion_tareas,
            usuario.principal_name AS correo,
            autorizacion.estado As estado
        
        FROM horario
        JOIN semestre ON semestre.id = horario.id_semestre
        JOIN laboratorio ON laboratorio.id = horario.id_laboratorio
        JOIN solicitud ON solicitud.id_laboratorio = laboratorio.id
        JOIN solicitudes_varias ON solicitudes_varias.id_solicitud = solicitud.id
        JOIN tipo_uso ON tipo_uso.id = solicitudes_varias.id_tipo_uso
        JOIN db_compartida.puesto_empleado ON puesto_empleado.idpuesto = solicitud.id_puesto_empleado
        JOIN db_compartida.usuario ON usuario.idusuario =puesto_empleado.idusuario
        JOIN autorizacion on autorizacion.id_solicitud = solicitud.id
        WHERE laboratorio.id=$idLaboratorio AND semestre.estado=1;
    

        EOL;
        

        $query = $this->db->query($sql);
        $solicitud = $query->getResultArray();

        foreach ($solicitud as $key => $row) {
            switch ($row['estado']) {
                case 0:
                    $solicitud[$key]['estado'] = 'Enviado';
                    break;
                case 1:
                    $solicitud[$key]['estado'] = 'Aceptado';
                    break;
                case 2:
                    $solicitud[$key]['estado'] = 'Rechazado';
                    break;
                default:
                    $solicitud[$key]['estado'] = 'Desconocido'; 
            }
        }

        return $solicitud;
    }

    public function mostrarDatosSolicitud($idLaboratorio)
    {
        $sql = <<<EOL

            SELECT 
                solicitud.id AS solicitud_id,
                solicitud.hora_fecha_entrada AS fecha_hora_entrada,
                solicitud.hora_fecha_salida AS fecha_hora_salida, 
                solicitud.fecha_envio,
                solicitudes_practicas.nombre_practica AS titulo,
                solicitudes_practicas.objetivo AS objetivo,
                carrera.nombre AS carrera ,
                asignatura.clave AS clave_asignatura ,
                grupo.nombre AS grupo,
                '' AS tipo_uso_varias,
                '' AS descripcion_tareas,
                usuario.principal_name AS correo,
                autorizacion.estado As estado
        FROM horario
        JOIN semestre ON semestre.id = horario.id_semestre    
        JOIN laboratorio ON laboratorio.id = horario.id_laboratorio
        JOIN solicitud ON solicitud.id_laboratorio = laboratorio.id
        JOIN solicitudes_practicas ON solicitudes_practicas.id_solicitud = solicitud.id  
        JOIN clase ON clase.id = solicitudes_practicas.id_clase
        JOIN reticula ON reticula.id_carrera = clase.id_carrera AND reticula.id_asignatura = clase.id_asignatura
        JOIN carrera ON carrera.id = reticula.id_carrera
        JOIN asignatura ON asignatura.id = reticula.id_asignatura
        JOIN grupo ON grupo.id = clase.id_grupo
        JOIN db_compartida.puesto_empleado on db_compartida.puesto_empleado.idpuesto= solicitud.id_puesto_empleado
        JOIN db_compartida.usuario on usuario.idusuario= puesto_empleado.idusuario
        JOIN autorizacion on autorizacion.id_solicitud = solicitud.id
        WHERE laboratorio.id= $idLaboratorio AND semestre.estado=1

        UNION 

        SELECT 
            solicitud.id AS solicitud_id,
            solicitud.hora_fecha_entrada AS fecha_hora_entrada,
            solicitud.hora_fecha_salida AS fecha_hora_salida,
            solicitud.fecha_envio,
            solicitudes_varias.nombre_proyecto AS titulo,
            ''AS objetivo,
            ''AS carrera,
            ''AS clave_asignatura,
            ''AS grupo,
            tipo_uso.nombre AS tipo_uso_varias,
            solicitudes_varias.descripcion_tareas AS  descripcion_tareas,
            usuario.principal_name AS correo,
            autorizacion.estado As estado
        
        FROM horario
        JOIN semestre ON semestre.id = horario.id_semestre
        JOIN laboratorio ON laboratorio.id = horario.id_laboratorio
        JOIN solicitud ON solicitud.id_laboratorio = laboratorio.id
        JOIN solicitudes_varias ON solicitudes_varias.id_solicitud = solicitud.id
        JOIN tipo_uso ON tipo_uso.id = solicitudes_varias.id_tipo_uso
        JOIN db_compartida.puesto_empleado ON puesto_empleado.idpuesto = solicitud.id_puesto_empleado
        JOIN db_compartida.usuario ON usuario.idusuario =puesto_empleado.idusuario
        JOIN autorizacion on autorizacion.id_solicitud = solicitud.id
        WHERE laboratorio.id=$idLaboratorio AND semestre.estado=1;
    

        EOL;
       

        $query = $this->db->query($sql);
        $solicitud = $query->getResultArray();
    

        return $solicitud;
    }
}
