<?php

// app/Models/UserModel.php
namespace App\Models\Reposs;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup = "residentes"; // database group
    protected $table = 'residente';  // Nombre de la tabla
    protected $primaryKey = 'idresidente'; // Clave primaria de la tabla
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'idprograma_educativo',
        'idpuesto',
        'numero_control',
        'correo_institucional',
        'nombre',
        'apellido1',
        'apellido2',
        'domicilio',
        'correo',
        'ciudad',
        'seguro_social',
        'numero_ss',
        'telefono',
        'celular',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'idprograma_educativo'  => 'required',
        'idpuesto'              => 'required',
        'numero_control'        => 'required',
        'correo_institucional'  => 'required',
        'nombre',
        'apellido1',
        'apellido2',
        'domicilio',
        'correo',
        'ciudad',
        'seguro_social',
        'numero_ss',
        'telefono',
        'celular',
    ];
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
    public function getUserByUsernamePassword($username, $password)
    {
        return $this->where('userPrincipalName', $username)
            ->where('password', $password)  // Asegúrate de cifrar la contraseña en producción
            ->first();
    }

    // Inserta un nuevo usuario
    public function insertNewUser($username, $password)
    {
        $data = [
            'username' => $username,
            'password' => $password,  // Aquí también deberías cifrar la contraseña antes de insertarla
            'userPrincipalName' => $username  // Por ejemplo, generar un email si no se tiene uno
        ];
        return $this->insert($data);
    }
}