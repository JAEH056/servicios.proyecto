<?php

    namespace App\Controllers\Labs;

    use App\Models\Labs\LaboratorioModel;
    use App\Models\Labs\CarreraModel;
    

    class Laboratorios extends MyController
    {

        protected $model_laboratorio;
        protected $model_carrera;


        public function __construct()
        {
            $this->model_laboratorio = model(LaboratorioModel::class);
            $this->model_carrera = model(CarreraModel::class);
        }


        public function index()
        {
            $laboratorios = $this->model_laboratorio->obtenerLaboratorios();

            $data = [
                'laboratorios' => $laboratorios,
            ];

            return view('Labs/layouts/laboratorio', $data);
        }


        public function nuevo()
        {
            helper('form');
            $carrera = $this->model_carrera->obtenerCarrera();

            $data = [
                'carrera' => $carrera,
                'validation' => null,
                'success' => null,
            ];

            return view('Labs/layouts/agregar_laboratorio', $data);
        }


        public function crear()
        {
            helper('form');
            $rules = $this->model_laboratorio->reglasValidacion();

            $carrera = $this->model_carrera->obtenerCarrera();

            $data = [
                'id_carrera' => $this->request->getPost('id_carrera'),
                'nombre' => $this->request->getPost('nombre'),
            ];

            if (!$this->validate($rules)) {
                return view('Labs/layouts/agregar_laboratorio', [
                    'carrera' => $carrera,
                    'validation' => $this->validator,
                    'success' => null,
                ]);
            }

            $this->model_laboratorio->insertarLaboratorio($data);

            return redirect()->to('/laboratorio/nuevo')->with('success', 'Laboratorio creado con éxito.');
        }

        public function editar($id)
        {
            helper('form');

            try {

                $laboratorio = $this->model_laboratorio->editarLaboratorio($id);
                $carreras = $this->model_carrera->obtenerCarrera();

                return view('Labs/layouts/editar_laboratorio', [
                    'laboratorio' => $laboratorio,
                    'carrera' => $carreras,
                    'validation' => null
                ]);
            } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
                return redirect()->to('/laboratorio')->with('error', $e->getMessage());
            }
        }


        public function actualizar($id)
        {
            helper('form');


            $rules = $this->model_laboratorio->reglasValidacion();


            $data = [
                'id_carrera' => $this->request->getPost('id_carrera'),
                'nombre' => $this->request->getPost('nombre'),
            ];


            if (!$this->validate($rules)) {

                return view('Labs/layouts/editar_laboratorio', [
                    'laboratorio' => $this->model_laboratorio->editarLaboratorio($id),
                    'carrera' => $this->model_carrera->obtenerCarrera(),
                    'validation' => $this->validator
                ]);
            }

            try {

                $this->model_laboratorio->actualizarLaboratorio($id, $data);

                return redirect()->to("/laboratorio/editar/$id")->with('success', 'Laboratorio actualizado con éxito.');
            } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
                return redirect()->to('/laboratorio')->with('error', $e->getMessage());
            } catch (\RuntimeException $e) {
                return redirect()->to("/laboratorio/editar/$id")->with('error', $e->getMessage());
            } catch (\Exception $e) {
                return redirect()->to('/laboratorio')->with('error', 'Ocurrió un error inesperado.');
            }
        }


        public function eliminar($id)
        {
            try {
                $this->model_laboratorio->eliminarLaboratorio($id);

                return redirect()->to('/laboratorio')->with('success', 'Laboratorio eliminado con éxito.');
            } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
                return redirect()->to('/laboratorio')->with('error', $e->getMessage());
            } catch (\RuntimeException $e) {
                return redirect()->to('/laboratorio')->with('error', $e->getMessage());
            } catch (\Exception $e) {
                return redirect()->to('/laboratorio')->with('error', 'Ocurrió un error inesperado al intentar eliminar el laboratorio.');
            }
        }
    }
