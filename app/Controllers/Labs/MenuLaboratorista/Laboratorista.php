<?php

namespace App\Controllers\Labs\MenuLaboratorista;

use App\Controllers\BaseController;
use App\Models\Labs\AsignarLaboratorioModel;

class Laboratorista extends BaseController
{
   
    protected $model_asignar_laboratorio;
    protected $model_laboratorio;
    //protected $id_usuario;
    public function __construct()
    {
       $this->model_asignar_laboratorio=model(AsignarLaboratorioModel::class);
      // $this->model_laboratorio=model(Laboratorio::class);
      

    
    }

    public function index(){
        $encargado_Laboratorio = $this->model_asignar_laboratorio->obtenerLaboratorioPorEncargado(1);
        // $laboratorio=$this->model_laboratorio->obtener
        // Verifica si los datos fueron obtenidos correctamente
        if (empty($encargado_Laboratorio)) {
            echo "No se encontraron laboratorios para el encargado.";
        } else {
        }
    
        
        $data = [
            'laboratoriosEncargado' => $encargado_Laboratorio,
        ];
    
        return view("Labs/layouts/laboratoristas", $data);
    }
    
}
