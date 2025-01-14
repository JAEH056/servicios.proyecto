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

    public function insertarSolicitud($dataSolicitud)
    {

     
        $this->db->transStart();
         $insert = $this->insert($dataSolicitud);


        // if ($this->db->transStatus() === false) {
        //     $this->db->transRollback();
        //     return false;
        // }

        $this->db->transComplete();
        return $insert; //this->getInsertID();
    }

     public function editar($idSolicitud = null):array{
        $sql = <<<EOL
        SELECT 
            solicitud.hora_fecha_entrada AS hora_fecha_entrada,
            solicitud.hora_fecha_salida AS hora_fecha_salida,
            laboratorio.nombre AS nombre_laboratorio,
            solicitudes_varias.nombre_proyecto AS nombre_proyecto,
            solicitudes_varias.descripcion_tareas AS descripcion_tareas,
        
            tipo_uso.nombre AS tipo_uso,
            '' AS objetivo,
            '' AS carrera,
            '' AS clave,
            '' AS grupo,
            usuario.principal_name AS correo,
            autorizacion.estado AS estado,
            autorizacion.observacion As observaciones
            
            
        FROM 
        solicitud
        JOIN laboratorio ON laboratorio.id= solicitud.id_laboratorio
        JOIN solicitudes_varias ON solicitudes_varias.id_solicitud = solicitud.id
        JOIN tipo_uso ON tipo_uso.id =solicitudes_varias.id_tipo_uso
        JOIN db_compartida.puesto_empleado ON puesto_empleado.idpuesto = solicitud.id_puesto_empleado
        JOIN db_compartida.usuario ON usuario.idusuario =puesto_empleado.idusuario
        JOIN autorizacion on autorizacion.id_solicitud = solicitud.id
        where solicitud.id=$idSolicitud

        UNION

        SELECT 
            solicitud.hora_fecha_entrada AS hora_fecha_entrada,
            solicitud.hora_fecha_salida AS hora_fecha_salida,
            laboratorio.nombre AS nombre_laboratorio,
            solicitudes_practicas.nombre_practica  As nombre_practica,
            '' AS descripcion_tareas,
            ''AS tipo_uso,
            solicitudes_practicas.objetivo AS objetivo,
            carrera.nombre AS carrera,
            asignatura.clave AS clave,
            grupo.nombre AS grupo,
            usuario.principal_name AS correo,
            autorizacion.estado AS estado,
            autorizacion.observacion As observaciones
            
            
        FROM 
        solicitud
        JOIN laboratorio ON laboratorio.id= solicitud.id_laboratorio
        JOIN solicitudes_practicas ON solicitudes_practicas.id_solicitud = solicitud.id
        JOIN clase ON clase.id = solicitudes_practicas.id_clase
        JOIN reticula ON reticula.id_carrera = clase.id_carrera AND reticula.id_asignatura = clase.id_asignatura
        JOIN carrera ON carrera.id = reticula.id_carrera
        JOIN asignatura ON asignatura.id = reticula.id_asignatura
        JOIN grupo ON grupo.id = clase.id_grupo

        JOIN db_compartida.puesto_empleado ON puesto_empleado.idpuesto = solicitud.id_puesto_empleado
        JOIN db_compartida.usuario ON usuario.idusuario =puesto_empleado.idusuario
        JOIN autorizacion on autorizacion.id_solicitud = solicitud.id

        where solicitud.id=$idSolicitud;
        EOL;
        $query = $this->db->query($sql);
        return $query->getResultArray();

        
     }
    
}
