<?php

namespace App\Models\Labs;

use CodeIgniter\Model;

class OrganigramaModel extends Model
{
    protected $DBGroup = 'laboratorios';
    protected $table      = 'organigrama';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombreM', 'nombreF', 'cargo', 'izquierda', 'derecha'];

    public function obtenerCargos(): array
    {
        // $cargo=$this->findAll();
        $builder = $this->db->table('organigrama')
            ->select('organigrama.id,
                      organigrama.cargo AS cargo');
        $query = $builder->get();
        $cargoEmpleado = $query->getResultArray();
        return $cargoEmpleado;
    }
}
