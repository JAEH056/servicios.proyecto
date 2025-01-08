<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class SolicitudesVariasModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'solicitudes_varias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_solicitud',
        'id_tipo_uso',
        'descripcion_tareas',
        'nombre_proyecto',
    ];

    // Validation
    protected $validationRules      = [
        'id_tipo_uso' => 'required|is_natural_no_zero',
        'descripcion_tareas' => 'required|max_length[255]|min_length[10]',
        'nombre_proyecto' => 'required|max_length[255]|min_length[10]',

    ];
    protected $validationMessages = [
        'id_tipo_uso' => [
            'required'           => 'El tipo de uso es obligatorio. Por favor seleccione una opción.',
            'is_natural_no_zero' => 'El tipo seleccionado no es válido. Selecciona una opción válida.'
        ],
        'descripcion_tareas' => [
            'required'   => 'La descricpcion de tareas es obligatoria.',
            'max_length' => 'La descripcion  no puede tener más de 255 caracteres.',
            'min_length' => 'El descripcion debe tener al menos 10 caracteres.',
        ],
        'nombre_proyecto' => [
            'required'   => 'El nombre del proyecto es obligatorio.',
            'max_length' => 'El nombre no puede tener más de 255 caracteres.',
            'min_length' => 'El nombre debe tener al menos 10 caracteres.',
        ],
    ];

    public function insertarSolicitudeVarias($dataSolicitudesVarias) {
          // Iniciar la transacción
          $this->db->transStart();

          // Insertar solicitud
          $this->insert($dataSolicitudesVarias);
  
          // Verificar el estado de la transacción
          if ($this->db->transStatus() === false) {
              // Si la transacción falla, revertir los cambios
              $this->db->transRollback();
              return false; // Devolver false para indicar que la operación falló
          }
  
          // Si todo es exitoso, completar la transacción
          $this->db->transComplete();
  
          // Si todo fue bien, devolver el ID de la solicitud insertada
          return true;
      
    }
}
