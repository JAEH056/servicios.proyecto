<?php

namespace App\Controllers\Labs;

use App\Models\Labs\DiasInhabilesModel;
use App\Models\Labs\TipoDiaInhabilModel;

class DiasInhabiles extends MyController
{
    public function index()
    {
        $model = model(DiasInhabilesModel::class);
       
        $data = [
            $dias = $model->listarDiasInhabiles(),
            'dias' => $dias,
        ];
        return view('Labs/layouts/dias_inhabiles', $data);
    }

    private function getValidationRules()
    {
        return [
            'tipo_inhabil' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'El tipo de día inhábil es obligatorio.',
                    'integer' => 'El tipo de día inhábil debe ser un número válido.'
                ]
            ],
            'nombre' => [
                'rules' => 'required|max_length[255]|min_length[8]',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                    'min_length' => 'El nombre debe tener al menos 8 caracteres.'
                ]
            ],
            'inicio' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha es obligatoria.',
                    'valid_date' => 'La fecha no es válida.'
                ]
            ],
            'fin' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha es obligatoria.',
                    'valid_date' => 'La fecha no es válida.'
                ]
            ]
        ];
    }

    public function formularioDias()
    {
        helper('form');
        $model = model(TipoDiaInhabilModel::class);
        $tiposdia = $model->obtenerTiposInhabiles();
        $data = [
            'dias' => $tiposdia,
            'validation' => null,
        ];
        return view('Labs/layouts/agregar_dias_inhabiles', $data);
    }


    public function crearDiaInhabil()
    {
        helper('form');
        $data = $this->request->getPost(['tipo_inhabil', 'nombre', 'inicio', 'fin']);
        $rules = $this->getValidationRules();

        if (!$this->validate($rules)) {
            return view('Labs/layouts/agregar_dias_inhabiles', [
                'dias' => model(TipoDiaInhabilModel::class)->obtenerTiposInhabiles(),
                'validation' => \Config\Services::validation()
            ]);
        }
        $model = model(DiasInhabilesModel::class);
        if (!$model->save([
            'id_tipo_inhabil' => $data['tipo_inhabil'],
            'descripcion' => $data['nombre'],
            'inicio' => $data['inicio'],
            'fin' => $data['fin']
        ])) //{
        //     return view('Labs/layouts/agregar_dias_inhabiles', [
        //         'dias' => model(TipoDiaInhabilModel::class)->obtenerTiposInhabiles(),
        //         'validation' => $model->errors()
        //     ]);
        // }

        return view('Labs/layouts/agregar_dias_inhabiles', [
            'dias' => model(TipoDiaInhabilModel::class)->obtenerTiposInhabiles(),
            'validation' => null,
            'success' => 'Día inhábil agregado correctamente.',
        ]);
    }

    public function editar($id)
    {
        helper('form');
        $model = model(DiasInhabilesModel::class);
        $tipoinhabil = model(TipoDiaInhabilModel::class);
        $tipo_inhabil = $tipoinhabil->findAll();

        $dia = $model->find($id);
        if (!$dia) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("El registro con ID $id no existe.");
        }
        $data = [
            'dia' => $dia,
            'tipos' => $tipo_inhabil
        ];

        print_r($data);
        return view('Labs/layouts/editar_dias_inhabiles', $data);
    }

    public function actualizarDiaInhabil($id)
    {
        helper('form');
        $data = $this->request->getPost(['tipo_inhabil', 'nombre', 'inicio', 'fin']);
        $model = model(DiasInhabilesModel::class);
        $tipoinhabilModel = model(TipoDiaInhabilModel::class);


        $rules = $this->getValidationRules();

        if (!$this->validate($rules)) {

            return view('Labs/layouts/editar_dias_inhabiles', [
                'dia' => $model->find($id),
                'tipos' => $tipoinhabilModel->findAll(),
                'validation' => \Config\Services::validation()
            ]);
        }


        $model = model(DiasInhabilesModel::class);
        if (!$model->update($id, [
            'id_tipo_inhabil' => $data['tipo_inhabil'],
            'descripcion' => $data['nombre'],
            'inicio' => $data['inicio'],
            'fin' => $data['fin']
        ]));

        // return redirect()->to('diasinhabiles')->with('success', 'Registro eliminado correctamente.');
        return view('diasinhabiles', [
            'validation' => null,
            'success' => 'Día inhábil agregado correctamente.',
        ]);
    }

    public function eliminar($id)
    {
        $model = model(DiasInhabilesModel::class);


        $dia = $model->find($id);
        if (!$dia) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("El registro con ID $id no existe.");
        }


        if ($model->delete($id)) {

            return redirect()->to('diasinhabiles')->with('success', 'Registro eliminado correctamente.');
        } else {

            return redirect()->to('diasinhabiles')->with('error', 'No se pudo eliminar el registro.');
        }
    }
}
