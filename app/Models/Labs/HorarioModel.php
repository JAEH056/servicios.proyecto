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

    // public function obtenerHorarios():array
    // {
       

        // $sql = <<<EOL
        //         SELECT 
        //         semestre.inicio ,
        //         semestre.fin,
        //         laboratorio.nombre,
        //         carrera.nombre
        //         FROM horario
    
        //         Join semestre on semestre.id= horario.id_semestre
    
        //         join laboratorio on laboratorio.id= id_laboratorio
        //         join carrera on carrera.id= laboratorio.id_carrera
        //         where horario.id_laboratorio=1
               

        //     EOL;

    //     $query = $this->db->query($sql);
    //     $horarios = $query->getResultArray();

    //     return $horarios;
    // }



    public function reglasValidacion()
    {
        return [
            'id_semestre' => [
                'rules' => 'required|',
                'errors' => [
                    'required' => 'Campo Obligatorio',

                ]
            ],
            'id_laboratorio' => [
                'rules' => 'required|',
                'errors' => [
                    'required' => 'Campo Obligatorio',

                ]
            ],

        ];
    }


    public function obtenerHorariosPorLaboratorio($idLaboratorio): array
    {
        $builder = $this->db->table('horario') 
            ->select('laboratorio.id AS laboratorio_id,
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






    public function insertarHorario($data)
    {
        return $this->insert($data);
    }
}


  // public function obtenerHorariosPorLaboratorio($idLaboratorio)
    // {
    //     $sql = <<<EOL
    //         SELECT 
    //             laboratorio.id As laboratorio_id,
    //             semestre.inicio AS inicio,
    //             semestre.fin AS fin,
    //             laboratorio.nombre AS nombre_laboratorio,
    //             carrera.nombre AS nombre_carrera
    //         FROM horario
    //         JOIN semestre ON semestre.id = horario.id_semestre
    //         JOIN laboratorio ON laboratorio.id = horario.id_laboratorio
    //         JOIN carrera ON carrera.id = laboratorio.id_carrera
    //         WHERE horario.id_laboratorio = ?
    //         AND semestre.estado = 1
    //     EOL;
    
    //     $query = $this->db->query($sql, [$idLaboratorio]);
    //     $resultados = $query->getResultArray();
    
        // Depuración: verificar lo que devuelve la consulta SQL
        // if (empty($resultados)) {
        //     echo "No se encontraron datos para la consulta SQL.";
        // } else {
        //     echo "Resultados de la consulta SQL: ";
        //     print_r($resultados);
        // }
    
      //  return $resultados;
   // }