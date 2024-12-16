<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class AsignarLaboratorioModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'asignar_laboratorio';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_usuario', 'id_laboratorio', 'inicio', 'fin'];

    // public function obtenerLaboratoriosAsigando(){

    //      $sql = <<<EOL

    //      SELECT 
    //      GROUP_CONCAT(
    //      CONCAT(usuario.nombre, ' ', usuario.apellido1, ' ', usuario.apellido2) 
    //      ORDER BY usuario.id ASC
    //      ) AS encargado,
	//         laboratorio.nombre AS nombre_laboratorio,
    //         asignar_laboratorio.inicio AS fecha_inicio,
    //         asignar_laboratorio.fin AS fecha_fin
    
    //     FROM asignar_laboratorio
    //     JOIN laboratorio ON asignar_laboratorio.id_laboratorio = laboratorio.id
    //     JOIN usuario ON asignar_laboratorio.id_usuario = usuario.id
 
 
    //     GROUP BY laboratorio.id,
    //       asignar_laboratorio.inicio,
    //       asignar_laboratorio.fin
    //      EOL;
    // }

    public function obtenerLaboratorioPorEncargado($id_usuario, \DateTimeImmutable $fecha_actual = null)
{
    // Si no se pasa una fecha, usar la fecha actual
    $fecha_actual = !is_null($fecha_actual) ? $fecha_actual : new \DateTimeImmutable();
    $fecha_actualStr = $fecha_actual->format('Y-m-d');

    // Construir la consulta con el builder
    $builder = $this->db->table('asignar_laboratorio')
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



//         $sql = <<<EOL
// SELECT 
//     laboratorio.nombre AS nombre_laboratorio,
//     asignar_laboratorio.inicio AS inicio,
//     asignar_laboratorio.fin AS fin,
//     GROUP_CONCAT(
//         CONCAT(usuario.nombre, ' ', usuario.apellido1, ' ', usuario.apellido2) 
//         ORDER BY usuario.id ASC
//     ) AS encargado
// FROM asignar_laboratorio
// JOIN laboratorio ON asignar_laboratorio.id_laboratorio = laboratorio.id
// JOIN usuario ON asignar_laboratorio.id_usuario = usuario.id
// WHERE usuario.id =$id_usuario
// AND asignar_laboratorio.inicio <=  '$fecha_actualStr'
// AND (
//     asignar_laboratorio.fin IS NULL OR
//     asignar_laboratorio.fin >= '$fecha_actualStr'
// )
// GROUP BY laboratorio.id,
//          asignar_laboratorio.inicio,
//           asignar_laboratorio.fin
// EOL;

         

            
           
            // $query = $this->db->query($sql);
            // $laboratoriosAsignados= $query ->getResultArray();
            //     print_r($laboratoriosAsignados);
              
            // return $laboratoriosAsignados;
    
        

}
