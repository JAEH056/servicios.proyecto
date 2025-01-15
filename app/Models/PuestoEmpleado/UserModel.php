<?php

namespace App\Models\PuestoEmpleado;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup = 'compartida';
    protected $table = 'usuario';
    protected $primaryKey = 'idusuario';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['idusuario', 'principal_name', 'nombre', 'apellido1', 'apellido2',];

    public function findByCorreo($correo)
    {
        return $this->where('principal_name', $correo)->first();
    }

    /**
     *  FUNCION PARA BARRA DE BUSQUEDA:
     *  Busqueda de toda la informacion relacionada con el usuario
     */
    public function buscarAsesoresPorNombreCompleto($nombreCompleto)
    {

        return $this->select('pe.idpuesto, usuario.principal_name, usuario.nombre, usuario.apellido1, usuario.apellido2, og.cargo, ga.programa_educativo, ga.siglas')
            ->join('db_compartida.puesto_empleado pe', 'usuario.idusuario = pe.idusuario', 'left')
            ->join('db_compartida.organigrama og', 'pe.idorganigrama = og.idorganigrama', 'left')
            ->join('db_compartida.grado_academico ga', 'usuario.idusuario = ga.idusuario', 'left')
            ->groupStart()
            ->like('nombre', $nombreCompleto)
            ->orLike('apellido1', $nombreCompleto)
            ->orLike('apellido2', $nombreCompleto)
            ->groupEnd()
            ->findAll();
    }
}
