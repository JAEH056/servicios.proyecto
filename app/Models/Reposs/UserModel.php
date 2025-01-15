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
    protected $allowedFields    = ['idusuario', 'principal_name', 'nombre', 'apellido1', 'apellido2']; // Campos que se pueden insertar

    // Otros métodos que puedas necesitar, por ejemplo, validaciones.
    public function insertData($data)
    {
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
        return empty($this->where('principal_name', $correo)->first());
    }

    /**
     *  Funcion para actualizar los datos del usuario (empleado)
     *  Verifica que los datos sean los mismos que en la BD.
     */
    public function actualizarNombreUsuario(array $nombreCompleto, int $idUsuario): array
    {
        // Obtener el usuario actual de la base de datos
        $usuario = $this->find($idUsuario);

        // Si no se encuentra el usuario, retornar false
        if (!$usuario) {
            return [
                'success' => false,
                'mensaje' => 'No se encontro el usuario'
            ];
        }

        // Separar los apellidos
        $apellidos = $this->splitSurname($nombreCompleto['surname']);

        // Verificar si los datos coinciden
        if (
            $usuario['nombre'] === $nombreCompleto['givenName'] &&
            $usuario['apellido1'] === $apellidos['apellido1'] &&
            $usuario['apellido2'] === $apellidos['apellido2']
        ) {
            return [
                'success' => true,
                'mensaje' => 'No es necesario actualizar'
            ];
        }

        // Actualizar los datos del usuario
        $data = [
            'nombre'    => $nombreCompleto['nombre'],
            'apellido1' => $nombreCompleto['apellido1'],
            'apellido2' => $nombreCompleto['apellido2'],
        ];
        // se actualizan los datos
        if (!$this->update($idUsuario, $data)) {
            return [
                'success' => false,
                'mensaje' => 'Error al actualizar nombre de usuario'
            ];
        }
        return [
            'success' => true,
            'mensaje' => 'Datos actualizados correctamente'
        ];
    }

    // Retorna los datos del usuario usando el correo como metodo de busqueda.
    public function findByCorreo($correo)
    {
        return $this->where('principal_name', $correo)->first();
    }
    // Busca el puesto del usuario usando su correo y retorna un arreglo.
    public function getPuestoCorreo($field, $correo)
    {
        $builder = $this->builder();
        $builder = $this->select('idusuario')->where($field, $correo['principal_name']);
        return  $builder->getRowArray();
    }
    public function splitSurname(string $fullSurname): array
    {
        // Usa explode() para romper la cadena en piezas separadas por espacios.
        $parts = explode(" ", $fullSurname);
        // Se revisa si tiene mas de una palabra (to ensure it's a full name).
        if (count($parts) > 1) {
            // Se separa la ultima palabra como segundo apellido.
            $familySurname = array_pop($parts);
            // Se unen las palabras restantes como el primer apellido.
            $prefixOrFirstSurname = implode(" ", $parts);
            // Se regresan las dos partes en un arreglo.
            return [
                'apellido1' => $prefixOrFirstSurname,
                'apellido2' => $familySurname
            ];
        } else {
            // Si no hay un espacio se regresa la cadena original.
            return [
                'apellido1' => $fullSurname,
                'apellido2' => ''
            ];
        }
    }
}
