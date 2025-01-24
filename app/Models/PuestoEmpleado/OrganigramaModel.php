<?php

namespace App\Models\PuestoEmpleado;

use CodeIgniter\Model;

class OrganigramaModel extends Model
{
    protected $DBGroup = 'compartida';
    protected $table = 'organigrama';
    protected $primaryKey = 'idorganigrama';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nombreM', 'nombreF', 'cargo', 'izquierda', 'derecha'];

    public function buscarCargoEmpleado(string $nombreTrabajo)
    {
        $cargo = explode(" ", $nombreTrabajo, 2);
        // Subconsulta laboratoristas a los cuales se les asignara un rol
        $subquery = $this->db->table('compartida.organigrama')
            ->select('idorganigrama, cargo')
            ->groupStart()
            ->where('idorganigrama', 13)
            ->orWhere('idorganigrama', 22)
            ->orWhere('idorganigrama', 25)
            ->groupEnd()
            ->getCompiledSelect();
        // Consulta principal para comparar el rol entrante (login)
        $query = $this->db->table("({$subquery}) AS labs")
            ->select('labs.idorganigrama, labs.cargo')
            ->like('labs.cargo', $cargo[0])
            ->orlike('labs.cargo', isset($cargo[1]) ? $cargo[1] : 'n/a')
            ->get()
            ->getRowArray();
        if ($query == null) {
            // Consulta secundaria cuando se tarte de otro puesto
            $query = $this->db->table('compartida.organigrama')
                ->select('organigrama.idorganigrama, organigrama.cargo')
                ->like('organigrama.cargo', $cargo[0])
                ->orlike('organigrama.cargo', isset($cargo[1]) ? $cargo[1] : 'n/a')
                ->get()
                ->getRowArray();
        }
        // Obtener el cargo del empleado 
        return $query;
    }
    public function buscarCargoNull()
    {
        return $this->where('cargo', null)->first();
    }
}
