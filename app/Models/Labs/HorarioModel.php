<?php

namespace App\Models\Labs;


class HorarioModel extends UserModel
{

    protected $table      = 'horario';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_semestre', 'id_laboratorio'];

    public function obtenerHorarios()
    {


        $sql = <<<EOL
            SELECT 
                semestre.id,
                semestre.nombre AS nombre_semestre,
                semestre.inicio AS inicio,
                semestre.fin as fin, 
                laboratorio.nombre AS nombre_laboratorio
            FROM horario
                join semestre on semestre.id = horario.id_semestre
                join laboratorio on laboratorio.id = horario.id_laboratorio

            EOL;

        $query = $this->db->query($sql);
        $horarios = $query->getResultArray();
        
        return $horarios;
    }



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

    // public function obtenerHorariosPorLaboratorio($idLaboratorio)
    // {
    //     return $this->where('id_laboratorio', $idLaboratorio)->findAll();
    // }



   
    
    public function insertarHorario($data)
    {
        return $this->insert($data);
    }
}
