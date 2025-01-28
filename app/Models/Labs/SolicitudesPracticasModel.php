<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class SolicitudesPracticasModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'solicitudes_practicas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';


    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_solicitud',
        'id_clase',
        'nombre_practica',
        'objetivo'
    ];

    // Validation
    protected $validationRules      = [
        'nombre_practica' => 'required|max_length[255]|min_length[10]',
        'objetivo' => 'required|max_length[255]|min_length[10]',

    ];
    protected $validationMessages = [
       
        'nombre_practica' => [
            'required'   => 'El nombre de la practica es obligatorio.',
            'max_length' => 'No puede tener más 255 caracteres.',
            'min_length' => 'Debe tener al menos 10 caracteres.',
        ],
        'objetivo' => [
            'required'   => 'El nombre objetivo es obligatorio.',
            'max_length' => 'El objetivo no puede tener más de 255 caracteres.',
            'min_length' => 'El objetivo debe tener al menos 10 caracteres.',
        ],
    ];

    public function insertarPracticas($dataSolicitudPractica)
    {
       
        $this->db->transStart();

        
        $this->insert($dataSolicitudPractica);

        
        if ($this->db->transStatus() === false) {
            
            $this->db->transRollback();
            return false; 
        }

       
        $this->db->transComplete();

        
        return true;
    }
}
