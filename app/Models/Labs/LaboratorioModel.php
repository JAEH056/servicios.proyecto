<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class LaboratorioModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'laboratorio';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_carrera', 'nombre'];


    protected $validationRules = [
        'nombre' => [
            'rules' => 'required|max_length[255]|min_length[4]',
            'errors' => [
                'required' => 'El nombre es obligatorio.',
                'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                'min_length' => 'El nombre debe tener al menos 4 caracteres.'
            ],
        ],

        'id_carrera' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La carrera es obligatoria',
                
            ],
        ],
    ];


    public function obtenerLaboratorios()
    {
        $builder = $this->db->table('laboratorio')
            ->select('laboratorio.id AS id, 
                  carrera.id AS carrera_id, 
                  carrera.nombre AS carrera_nombre, 
                  laboratorio.nombre AS nombre_laboratorio')
            ->join('carrera', 'carrera.id = laboratorio.id_carrera', 'LEFT')
            ->groupBy('laboratorio.id');

        $query = $builder->get();
        $laboratorios = $query->getResultArray();
        return $laboratorios;
    }


    public function insertarLaboratorio($data)
    {
        return $this->insert($data);
    }

    public function editarLaboratorio($id)
    {
        $laboratorio = $this->find($id);
        if (!$laboratorio) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("El laboratorio con ID $id no existe.");
        }
        return $laboratorio;
    }


    public function actualizarLaboratorio($id, $data)
    {
        $laboratorio = $this->find($id);

        if (!$laboratorio) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("El laboratorio con ID $id no existe.");
        }

        if (!$this->update($id, $data)) {
            throw new \RuntimeException("Error al actualizar el laboratorio con ID $id.");
        }
        return true;
    }


    public function eliminarLaboratorio($id)
    {
        $laboratorio = $this->find($id);
        if (!$laboratorio) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("El laboratorio con ID $id no existe.");
        }
        $result = $this->delete($id);
        if (!$result) {
            throw new \RuntimeException("No se pudo eliminar el laboratorio con ID $id.");
        }
        return true;
    }
}
