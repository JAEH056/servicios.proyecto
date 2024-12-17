<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class SemestreModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'semestre';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nombre', 'inicio', 'fin', 'estado'];

    // public function obtenerSemestre()
    // {
    //     $sql = <<<EOL
    //         SELECT 
    //             semestre.id AS id,
    //             semestre.nombre AS nombre  ,
    //             semestre.inicio AS inicio,
    //             semestre.fin as fin,
    //              semestre.estado AS estado
    //         FROM 
    //             semestre
    //         ORDER BY
    //         inicio ASC
    //         EOL;

    //     $query = $this->db->query($sql);
    //     $result = $query->getResultArray();
    //     foreach ($result as &$row) {
    //         $row['estado'] = $row['estado'] == 1 ? 'Activo' : 'Inactivo';
    //     }

    //     return $result;
    // }

    public function obtenerSemestre():array{
        $builder =$this->db->table($this->table)
        ->select('semestre.id AS id,
                  semestre.nombre AS nombre,
                  semestre.inicio AS inicio,
                  semestre.fin as fin,
                  semestre.estado AS estado')
        ->orderBy('inicio ASC');   
        $query = $builder->get();
        $periodo=$query->getResultArray();
        foreach ($periodo as &$row) {
            $row['estado'] = $row['estado'] == 1 ? 'Activo' : 'Inactivo';
        }
        return $periodo;
        
    }
 
    public function obtenerSemestreActivos() :array{
        $builder =$this->db->table($this->table)
        ->select('semestre.id AS id,
                  semestre.nombre AS nombre,
                  semestre.inicio AS inicio,
                  semestre.fin as fin,
                  semestre.estado AS estado')
        ->where('semestre.estado','1')         
        ->orderBy('inicio ASC');   
        $query = $builder->get();
        $periodo=$query->getResultArray();
        return $periodo;
        
    }



    public function fechaFinPosteriorAInicio(string $fechaInicio, string $fechaFin): bool
    {
        // Convertimos las fechas a objetos DateTimeImmutable
        $fechaInicioObj = new \DateTimeImmutable($fechaInicio);
        $fechaFinObj = new \DateTimeImmutable($fechaFin);

        // Comparamos las fechas
        return $fechaFinObj > $fechaInicioObj;
    }

    // Método que contiene las reglas de validación
    public function reglasValidacion()
    {
        return [
            'nombre' => [
                'rules' => 'required|max_length[255]|min_length[8]',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                    'min_length' => 'El nombre debe tener al menos 8 caracteres.',
                ],
            ],
            'inicio' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de inicio es obligatoria.',
                    'valid_date' => 'La fecha de inicio no es válida.',
                ],
            ],
            'fin' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de fin es obligatoria.',
                    'valid_date' => 'La fecha de fin no es válida.',
                ],
            ],
            'estado' => [
                'rules' => 'required|in_list[0,1]',
                'errors' => [
                    'required' => 'El estado es obligatorio.',
                    'in_list'  => 'El estado debe ser "Activo" (1) o "Inactivo" (0).',
                ],
            ],

        ];
    }


    public function insertarSemestre($data)
    {
        return $this->insert($data);
    }

    public function editarSemestre($id)
    {
        $semestre = $this->find($id);
        if (!$semestre) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("El laboratorio con ID $id no existe.");
        }
        return $semestre;
    }

    public function actualizarSemestre($id, $data)
    {
        $semestre = $this->find($id);

        if (!$semestre) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("El laboratorio con ID $id no existe.");
        }

        if (!$this->update($id, $data)) {
            throw new \RuntimeException("Error al actualizar el laboratorio con ID $id.");
        }

        return true;
    }

    public function eliminarSemestre($id)
    {
        $semestre = $this->find($id);
        if (!$semestre) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("El semestre con ID $id no existe.");
        }

        $result = $this->delete($id);
        if (!$result) {
            throw new \RuntimeException("No se pudo eliminar el semestre con ID $id.");
        }
        return true;
    }
}
