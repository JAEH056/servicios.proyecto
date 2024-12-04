<?php

namespace App\Controllers\Labs;

use App\Models\Labs\CarreraModel;
use \App\Models\Labs\LaboratorioModel;

class  Laboratorios extends MyController
{
    public function index()
    {

        $model = model(LaboratorioModel::class);
        $laboratorios = $model->obtenerLaboratorios();
        $data = [
            'laboratorios' => $laboratorios,
        ];
        return view('Labs/layouts/laboratorio', $data);
    }

    private function reglasValidacion()
    {
        return [
            'nombre_laboratorio' => [
                'rules' => 'required|max_length[255]|min_length[8]',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                    'min_length' => 'El nombre debe tener al menos 8 caracteres.'
                ],
            ],
        ];
    }

    public function nuevo()
    {
        helper('form');
        $model = model(CarreraModel::class);
        $carrera=$model->obtenerCarrera();
        $data = [
            //'title' => 'Agregar Semestre',
            'carrera'=>$carrera,
            'validation' => null,
            'success' => null, 
        ];
        return view('Labs/layouts/agregar_laboratorio', $data);
    }
    
    public function crear(){
        helper('form');
        $data = $this->request->getPost(['carrera','laboratorio']);
        $model = model(CarreraModel::class);
        $carrera=$model->obtenerCarrera();

        // Validar las reglas generales
        if (!$this->validate($this->reglasValidacion())) {
            return view('Labs/layouts/agregar_laboratorio', [
               // 'title' => 'Agregar Semestre',
                'carrera'=>$carrera,
                'validation' => \Config\Services::validation(),
                'success' => null,
            ]);
        }

        $model = model(LaboratorioModel::class);
        $model->save([
            'id_carrera' => $data['carrera'],
            'nombre' => $data['laboratorio'],
            
        ]);

        
        return redirect()->to('/laboratorio/nuevo')->with('success', 'Laboratorio agregado con éxito.');
    }

    public function editar($id){
        helper('form');
        $model = model(LaboratorioModel::class);
        $laboratorio =$model->finf($id);
        if(!$laboratorio){
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Laboratorio con ID $id no encontrado."); 
        }


        
    }
}
