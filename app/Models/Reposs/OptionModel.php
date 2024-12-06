<?php

// app/Models/UserModel.php
namespace App\Models\Reposs;

use CodeIgniter\Model;

class OptionModel extends Model
{
    protected $DBGroup = "residentes"; // database group
    protected $table = 'residente';  // Nombre de la tabla
    protected $primaryKey = 'idusuario'; // Clave primaria de la tabla
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'idusuario',
        'correo',
        'nombre',
        'apellido1',
        'apellido2'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
    protected array $casts = [];
    protected array $castHandlers = [];

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    // Obtiene un usuario por su nombre de usuario y contraseña
    public function getUserId($idusuario)
    {
        return $this->where('idusuario', $idusuario)->first();
    }
}