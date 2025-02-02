<?php

namespace App\Controllers\Labs\MenuLaboratorista;

use App\Controllers\BaseController;
use \App\Models\Labs\SemestreModel;


class Semestre extends BaseController
{
    protected $model_semestre;
    protected $helpers = ['form'];

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
            'user' => $user,
            'token' => $token,
            'idusuario' => $userId,
            'semestre' => $semestre,
        ];

        return view('Labs/layouts/semestre', $data);
    }

    public function nuevo()
    {
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');

        $data = [
            'user' => $user,
            'token' => $token,
            'idusuario' => $userId,

        ];

        return view('Labs/layouts/agregar_semestre', $data);
    }

    public function crear()
    {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'inicio' => $this->request->getPost('inicio'),
            'fin' => $this->request->getPost('fin'),
            'estado' => $this->request->getPost('estado'),
        ];

        if (!$this->validate($this->model_semestre->getValidationRules())) {
            return redirect()
                ->to(base_url('usuario/nuevo/semestre'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        if (!$this->model_semestre->fechaFinPosteriorAInicio($data['inicio'], $data['fin'])) {
            $this->validator->setError('fin', 'La fecha de fin debe ser posterior a la fecha de inicio.');
            return redirect()
                ->to(base_url('usuario/nuevo/semestre'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->model_semestre->insertarSemestre($data);
        return redirect()
            ->to(base_url('usuario/mostrar/semestre'))
            ->with('creado', 'Creado exitosamente');
    }

    public function editar($id = null)
    {
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');
        $semestre = $this->model_semestre->editarSemestre($id);
        $data = [
            'user' => $user,
            'token' => $token,
            'idusuario' => $userId,
            'semestre' => $semestre,
        ];

        return view('Labs/layouts/editar_semestre', $data);
    }

    public function actualizar($id = null)
    {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'inicio' => $this->request->getPost('inicio'),
            'fin'    => $this->request->getPost('fin'),
            'estado' => $this->request->getPost('estado'),
        ];
        if (!$this->validate($this->model_semestre->getValidationRules())) {
            return redirect()
                ->to(base_url('usuario/editar/semestre/' . esc($id)))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        if (!$this->model_semestre->fechaFinPosteriorAInicio($data['inicio'], $data['fin'])) {
            $this->validator->setError('fin', 'La fecha de fin debe ser posterior a la fecha de inicio.');
            return redirect()
                ->to(base_url('usuario/editar/semestre/' . esc($id)))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $this->model_semestre->actualizarSemestre($id, $data);
        return redirect()
            ->to(base_url('usuario/mostrar/semestre'))
            ->with('actualizado', 'Cambios actualizados');
    }

    public function eliminar($id)
    {
        $this->model_semestre->eliminarSemestre($id);
        return redirect()->to(base_url('usuario/mostrar/semestre'))
        ->with('eliminado', 'Completado correctamente');
    }
}
