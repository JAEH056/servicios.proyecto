<?php

namespace App\Controllers\Labs;

use App\Models\Labs\HorarioModel;
use App\Models\Labs\LaboratorioModel;
use App\Models\Labs\SemestreModel;

class CrearHorario extends MyController {

    protected $model_semestre;
    protected $model_horario;
    protected $model_laboratorio;
   
   

    public function __construct()
    {
        
        $this->model_semestre = model(SemestreModel::class);
        $this->model_horario = model(HorarioModel::class);
        $this->model_laboratorio = model(LaboratorioModel::class);
    }

    public function index()
        {
            

            $horarios = $this->model_horario->obtenerHorarios();

            $data = [
                'horarios' => $horarios
            ];

            
            return view('Labs/layouts/horario', $data);
        }

        public function nuevo()
        {
            helper('form');
            $semestre =$this->model_semestre->obtenerSemestre();
            $laboratorio=$this->model_laboratorio->obtenerLaboratorios();
          

            $data = [
                'semestre' => $semestre,
                'laboratorio'=>$laboratorio,
                'validation' => null,
                'success' => null,
            ];

            return view('Labs/layouts/agregar_horario', $data);
        }


    public function crear(){
        helper('form');
        $semestre =$this->model_semestre->obtenerSemestre();
        $laboratorio=$this->model_laboratorio->obtenerLaboratorios();
        $rules = $this->model_horario->reglasValidacion();
        $data =[
            'id_semestre'=> $this->request->getPost('id_semestre'),
            'id_laboratorio'=>$this->request->getPost('id_laboratorio'),

            
        ];
      
        if (!$this->validate($rules)) {
            return view('Labs/layouts/agregar_horario', [
                 'semestre' =>$semestre,
            'laboratorio' =>$laboratorio,
                'validation' => $this->validator,
                'success' => null,
            ]);
        }

        $this->model_horario->insertarHorario($data);

        return redirect()->to('/horario/nuevo')->with('success', 'Horario creado con éxito.');
    }


    public function mostrarHorario()
    {
      $periodo= $this->model_horario->obtenerHorarios();
      foreach ($periodo as $datosperiodo) {
        

        $data =[  
            'periodoJson' => json_encode([
           
            'inicio'=>$datosperiodo['inicio'],
            'fin'=>$datosperiodo['fin'],
        ]),
       
        ];
        print_r($periodo);
    
    }
    
    
        return view('Labs/layouts/horario_certificacion', $data); 
    }
    
    
}
