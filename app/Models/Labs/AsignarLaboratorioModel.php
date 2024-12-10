<?php

namespace App\Models\Labs;

class AsignarLaboratorioModel extends UserModel {
    protected $table      = 'asignar_laboratorio';
    protected $returnType     = 'array';
    protected  $useSoftDeletes = false;

    protected $allowedFields =['id_usuario','id_laboratorio'];


public function obtenerLaboratorioAdministrador(){
    return $this->findAll();

}
}