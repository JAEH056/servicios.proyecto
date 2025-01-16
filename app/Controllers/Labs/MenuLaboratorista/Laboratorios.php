<?php

namespace App\Controllers\Labs\MenuLaboratorista;

use App\Controllers\BaseController;
use App\Models\Labs\LaboratorioModel;
use App\Models\Labs\CarreraModel;


class Laboratorios extends BaseController
{

    protected $model_laboratorio;
    protected $model_carrera;
    protected $helpers = ['form'];


    public function __construct()
    {
        $this->model_laboratorio = model(LaboratorioModel::class);
        $this->model_carrera = model(CarreraModel::class);
    }

    //se anadio  la sesion

    public function index()
    {
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');

        $laboratorios = $this->model_laboratorio->obtenerLaboratorios();


        $data = [
            //para que se pasen los datos de sesion en la vista
            'user' => $user,
            'token' => $token,
            'idusuario' => $userId,
            'laboratorios' => $laboratorios,
        ];

        return view('Labs/layouts/laboratorio', $data);
    }


    public function nuevo()
    {
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');

        $carrera = $this->model_carrera->obtenerCarrera();

        $data = [
            'user' => $user,
            'token' => $token,
            'idusuario' => $userId,
            'carrera' => $carrera,

        ];

        return view('Labs/layouts/agregar_laboratorio', $data);
    }


    public function crear()
    {

        $data = [
            'id_carrera' => $this->request->getPost('id_carrera'),
            'nombre' => $this->request->getPost('nombre'),
        ];


        if (!$this->validate($this->model_laboratorio->getValidationRules())) {
            return redirect()
                ->to(base_url('usuario/nuevo/laboratorio'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->model_laboratorio->insertarLaboratorio($data);
        return redirect()
            ->to(base_url('usuario/mostrar/laboratorio'))
            ->with('creado', 'Creado exitosamente');
    }

    public function editar($id)
    {
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');
        $carreras = $this->model_carrera->obtenerCarrera();
        $laboratorio = $this->model_laboratorio->editarLaboratorio($id);
        $data = [
            'user' => $user,
            'token' => $token,
            'idusuario' => $userId,
            'carrera' => $carreras,
            'laboratorio' => $laboratorio
        ];

        return view('Labs/layouts/editar_laboratorio', $data);
    }


    public function actualizar($id)
    {
        
        $data = [
            'id_carrera' => $this->request->getPost('id_carrera'),
            'nombre' => $this->request->getPost('nombre'),
        ];

        if (!$this->validate($this->model_laboratorio->getValidationRules())) {
            return redirect()
                ->to(base_url('usuario/editar/laboratorio/' . esc($id)))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

            $this->model_laboratorio->actualizarLaboratorio($id, $data);
          return redirect() ->to(base_url('usuario/mostrar/laboratorio'))
            ->with('actualizado', 'Cambios actualizados');
    }


    public function eliminar($id)
    {

        $this->model_laboratorio->eliminarLaboratorio($id);

        return redirect()->to(base_url('usuario/mostrar/laboratorio'))
        ->with('eliminado', 'Completado correctamente');
    }
}
