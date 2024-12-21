<?php

    namespace App\Controllers\Labs;

use App\Controllers\BaseController;
use \App\Models\Labs\SemestreModel;


    class Semestre extends BaseController
    {
        protected $model_semestre;

        public function __construct()
        {
            $this->model_semestre = model(SemestreModel::class);
        }

        public function index()

        {
            if (!session()->has('name')) {
                return redirect()->to('/oauth/login');
            }
    
            $userId = session()->get('idusuario');
            $user = session()->get('name');
            $token = session()->get('access_token'); 

            $semestre = $this->model_semestre->obtenerSemestre();
            $data = [
                 'user' => $user, 'token' => $token, 'idusuario' => $userId,
                'semestre' => $semestre,
            ];

            return view('Labs/layouts/semestre', $data);
        }

        public function nuevo()
        {
            helper('form');
            $data = [
                'semestre' => null,
                'validation' => null,
                'success' => null,
            ];
            return view('Labs/layouts/agregar_semestre', $data);
        }

        public function crear()
        {
            helper('form');
            $rules = $this->model_semestre->reglasValidacion();

            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'inicio' => $this->request->getPost('inicio'),
                'fin' => $this->request->getPost('fin'),
                'estado' => $this->request->getPost('estado'),
            ];

            if (!$this->validate($rules)) {
                return view('Labs/layouts/agregar_semestre', [
                   // 'semestre' => $data,
                    'validation' => $this->validator,
                    'success' => null,
                ]);
            }

            if (!$this->model_semestre->fechaFinPosteriorAInicio($data['inicio'], $data['fin'])) {
                $this->validator->setError('fin', 'La fecha de fin debe ser posterior a la fecha de inicio.');
                return view('Labs/layouts/agregar_semestre', [
                   // 'semestre' => $data,
                    'validation' => $this->validator,
                    'success'    => null,
                ]);
            }

            try {
                $this->model_semestre->insertarSemestre($data);
                return redirect()->to('/semestre/nuevo')->with('success', 'Semestre agregado correctamente');
            } catch (\Exception) {
                return redirect()->to('/semestre/nuevo')->with('error', 'Ocurrió un error al agregar el semestre.');
            }
        }




        public function editar($id)
        {
            helper('form');
            

            try {
                $semestre = $this->model_semestre->editarSemestre($id);

                return view('Labs/layouts/editar_semestre', [

                    'semestre' => $semestre,
                    'validation' => null,
                ]);
            } catch (\Exception) {

                return redirect()->to('usuario/semestre/mostrar')->with('error', 'Ocurrió un error inesperado.');
            }
        }
        public function actualizar($id)
        {
            helper('form');
            $rules = $this->model_semestre->reglasValidacion();

            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'inicio' => $this->request->getPost('inicio'),
                'fin'    => $this->request->getPost('fin'),
                'estado' => $this->request->getPost('estado'),
            ];

            if (!$this->validate($rules)) {

                return view('Labs/layouts/agregar_semestre', [
                    'validation' => $this->validator,
                    'semestre' => $data,
                    'success' => null,
                    
                ]);
            }


            if (!$this->model_semestre->fechaFinPosteriorAInicio($data['inicio'], $data['fin'])) {
                $this->validator->setError('fin', 'La fecha de fin debe ser posterior a la fecha de inicio.');
                return view('Labs/layouts/agregar_semestre', [
                    'validation' => $this->validator,
                    'semestre' => $data,
                    'success'    => null,
                ]);
            }

            try {
                $this->model_semestre->actualizarSemestre($id, $data);

                return redirect()->to("/semestre/editar/$id")->with('success', 'Semestre actualizado con éxito.');
            }  catch (\Exception ) {
                return redirect()->to('/semestre')->with('error', 'Ocurrió un error inesperado.');
            }
        }

        public function eliminar($id)
        {
            try {
                $this->model_semestre->eliminarSemestre($id);

                return redirect()->to('/semestre')->with('success', 'Semestre eliminado con éxito.');
            } catch (\Exception $e) {
                return redirect()->to('/semestre')->with('error', 'Ocurrió un error inesperado al intentar eliminar el laboratorio.');
            }
        }
    }
