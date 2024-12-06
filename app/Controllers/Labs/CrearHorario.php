<?php

namespace App\Controllers\Labs;

use App\Models\Labs\HorarioModel;
use App\Models\Labs\SemestreModel;

class crearHorario extends MyController {

    protected $model_semestre;
    protected $model_horario;

    public function __construct()
    {
        
        $this->model_semestre =model(SemestreModel::class);
        $this->model_horario=model(HorarioModel::class);
    }

    public function crearHorario(){
        $semestre =$this->model_semestre->obtenerSemestre();
        $data =[
            'periodo' =>$semestre
            
        ];
    return view ('Labs/layoutslaboratorio',$data);

    }

}
