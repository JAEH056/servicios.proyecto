<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class DiasInhabilesModel extends Model
{

    protected $DBGroup = 'laboratorios';
    protected $table      = 'dias_inhabiles';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_tipo_inhabil', 'descripcion', 'inicio', 'fin'];

    public function obtenerDiasInhabiles(): array
    {
        $builder = $this->db->table($this->table)
            ->select('dias_inhabiles.id as id, 
                 dias_inhabiles.descripcion as nombre, 
                 tipo_dia_inhabil.nombre as tipo_inhabil,
                 dias_inhabiles.inicio as inicio, 
                 dias_inhabiles.fin as fin')
            ->join(
                'tipo_dia_inhabil',
                'tipo_dia_inhabil.id = dias_inhabiles.id_tipo_inhabil'
            )
            ->groupBy([
                'dias_inhabiles.id',
                'dias_inhabiles.inicio',
                'dias_inhabiles.fin'
            ])
            ->orderBy('dias_inhabiles.inicio', 'ASC');
        $query = $builder->get();
        $diasInhabiles = $query->getResultArray();
        return $diasInhabiles;
    }

    public function obtenerDiasInhabilesPorPeriodo($inicioPeriodo,$finPeriodo): array
    {
        $builder = $this->db->table($this->table)
            ->select('dias_inhabiles.id as id, 
                 dias_inhabiles.descripcion as nombre, 
                 tipo_dia_inhabil.nombre as tipo_inhabil,
                 dias_inhabiles.inicio as inicio, 
                 dias_inhabiles.fin as fin')
            ->join(
                'tipo_dia_inhabil',
                'tipo_dia_inhabil.id = dias_inhabiles.id_tipo_inhabil'
            )
            ->where('dias_inhabiles.inicio >=', $inicioPeriodo)
            ->where('dias_inhabiles.fin <= ', $finPeriodo)
            ->groupBy([
                'dias_inhabiles.id',
                'dias_inhabiles.inicio',
                'dias_inhabiles.fin'
            ])
            ->orderBy('dias_inhabiles.inicio', 'ASC');
        $query = $builder->get();
        $dias_inhabiles = $query->getResultArray();
        return $dias_inhabiles;
    }
    public function reglasValidacion()
    {
        return [
            'tipo_inhabil' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'El tipo de día inhábil es obligatorio.',
                    'integer' => 'El tipo de día inhábil debe ser un número válido.'
                ]
            ],
            'nombre' => [
                'rules' => 'required|max_length[255]|min_length[8]',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                    'min_length' => 'El nombre debe tener al menos 8 caracteres.'
                ]
            ],
            'inicio' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha es obligatoria.',
                    'valid_date' => 'La fecha no es válida.'
                ]
            ],
            'fin' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha es obligatoria.',
                    'valid_date' => 'La fecha no es válida.'
                ]
            ]
        ];
    }
    public function insertarDiaInhabil($data)
    {
        return $this->insert($data);
    }

    public function editarDiaInhabil($id)
    {
        $diaInhabil = $this->find($id);
        if (!$diaInhabil) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("El dia Inhabil con ID $id no existe.");
        }
        return $diaInhabil;
    }

    public function actualizarDiaInhabil($id, $data)
    {
        $diaInhabil = $this->find($id);

        if (!$diaInhabil) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("El laboratorio con ID $id no existe.");
        }

        if (!$this->update($id, $data)) {
            throw new \RuntimeException("Error al actualizar el laboratorio con ID $id.");
        }
        return true;
    }


    public function eliminarDiaInhabill($id)
    {
        $diaInhabil = $this->find($id);
        if (!$diaInhabil) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("El laboratorio con ID $id no existe.");
        }
        $result = $this->delete($id);
        if (!$result) {
            throw new \RuntimeException("No se pudo eliminar el laboratorio con ID $id.");
        }
        return true;
    }
}
