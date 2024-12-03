<?php

namespace App\Controllers\Labs;

use \App\Models\Labs\SemestreModel;

class Semestre extends MyController
{

    public function index()
    {
        $model = model(SemestreModel::class);
        $semestre = $model->obtenerSemestre();
        $data = [
            'semestre' => $semestre,
        ];
        return view('Labs/layouts/semestre', $data);
    }

    private function reglasValidacion()
    {
        return [
            'nombre' => [
                'rules' => 'required|max_length[255]|min_length[8]',
                'errors' => [
                    'required' => 'El nombre es obligatorio',
                    'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                    'min_length' => 'El nombre debe tener al menos 8 caracteres.'


                ]
            ],
            'inicio' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha es obligatoria.',
                    'validad_date' => 'La fecha no es válida.'

                ]
            ],

            'fin' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha es obligatoria.',
                    'required|valid_date|isAfter[inicio]'

                ]
            ],

        ];
    }

    public function nuevo()
    {
        helper('form');
        $model = model(SemestreModel::class);
        $semestre = $model->obtenerSemestre();
        $data = [
            'semestre' => $semestre,
            'validation' => null,
        ];
        return view('Labs/layouts/agregar_semestre', $data);
    }

    public function crear()
    {
        helper('form');
        $data = $this->request->getPost(['nombre','inicio','fin']);
        $rules = $this->reglasValidacion();
        if (!$this->validate($rules)) {
            return view('Labs/layouts/agregar_semestre', [
                'validation' => \Config\Services::validation()
            ]);

         }
         
          $model = model(SemestreModel::class);
            $model->save([
            'nombre' => $data['nombre'],
            'inicio' => $data['inicio'],
            'fin' => $data['fin']
            ]);
            return view("Labs/layouts/agregar_semestre",$data);
        
    }
}
