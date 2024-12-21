<?php

namespace App\Models\Reposs;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'compartida'; // database group
    protected $table            = 'usuario';  // Nombre de la tabla
    protected $primaryKey       = 'idusuario'; // Clave primaria de la tabla
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idusuario','principal_name', 'nombre', 'apellido1', 'apellido2']; // Campos que se pueden insertar

    // Otros métodos que puedas necesitar, por ejemplo, validaciones.
    public function insertData($data) {
        // Your existing insert logic
        return $this->insert($data);
    }
    /*
    *   IMPORTANTE: esta funcion es utilizada en el modelo Residentes
    *   con el mismo nombre (parte importante del proceso OAUTH).
    *   Eliminar o modificar esta funcion puede afectar la autenticacion.
    */
    public function esPrimerIngreso(string $correo): bool
    {
        return empty($this->where('principal_name',$correo)->first());
    }
    // Retorna los datos del usuario usando el correo como metodo de busqueda.
    public function findByCorreo($correo) {
        return $this->where('principal_name', $correo)->first();
    }
    // Busca el puesto del usuario usando su correo y retorna un arreglo.
    public function getPuestoCorreo($field,$correo){
        $builder = $this->builder();
        $builder = $this->select('idusuario')->where( $field,$correo['principal_name']);           
        return  $builder->getRowArray();
    }
}