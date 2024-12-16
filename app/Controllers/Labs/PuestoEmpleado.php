<?php

namespace App\Controllers\Labs;

use App\Controllers\BaseController;
use App\Models\Labs\OrganigramaModel;

class PuestoEmpleado extends BaseController {
    
    protected $model_organigrama;

    public  function __construct() {
        $this->model_organigrama= model(OrganigramaModel::class);
    }


    public function index(): string

    {
        $cargoObtenido = $this->model_organigrama->obtenerCargos();
        foreach( $cargoObtenido as $cargo){
           
        
        $data=[
            'cargos'=>[
            'id'=>$cargo['id'],
            'cargos'=>$cargo['cargo']
            

        ]];
        print_r($data);
    }
        return view('Labs/layouts/puesto_empleado',$data);
    }
}
