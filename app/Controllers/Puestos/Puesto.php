<?php

namespace App\Controllers\Puestos;

use App\Controllers\BaseController;
use App\Models\PuestoEmpleado\GradoAcademicoModel;
use App\Models\PuestoEmpleado\NivelModel;
use App\Models\PuestoEmpleado\PuestoEmpleadoModel;
use App\Models\PuestoEmpleado\UserModel;

class Puesto extends BaseController
{
    protected $modelo_user;
    protected $modelo_puesto_empleado;
    protected $modelo_nivel;
    protected $model_grado_academico;
    protected $userId;

    public function __construct()
    {
        $this->modelo_user = model(UserModel::class);
        $this->modelo_puesto_empleado = model(PuestoEmpleadoModel::class);
        $this->modelo_nivel = model(NivelModel::class);
        $this->model_grado_academico = model(GradoAcademicoModel::class);
        $this->userId = session()->get('idusuario');
    }

    public function index()
    {
        helper('form');
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $user = session()->get('name');
        $token = session()->get('access_token');
        $datoUsuario = $this->modelo_user->findByCorreo($user['userPrincipalName']);
        $puestoEmpleado = $this->modelo_puesto_empleado->puestoAsignadoPorUsuario($this->userId);
        $nivel = $this->modelo_nivel->obtenerNivel();
        $gradosAcademicos = $this->model_grado_academico->obtenerGrado($this->userId);

        $gradousuario = [];
        if (!empty($gradosAcademicos)) {
            foreach ($gradosAcademicos as $grado) {

                $gradousuario[] = [
                    'nombre_nivel' => $grado['nombre_nivel'],
                    'nombre_grado' => $grado['nombre_grado'],
                    'programa_educativo' => $grado['programa_educativo'],
                    'siglas' => $grado['siglas'],
                    'fecha_creacion' => $grado['fecha_creacion']
                ];
            }
        }

        $template = 'Labs/layouts/principal_laboratorista';

        $data = [
            'user' => $user,
            'token' => $token,
            'datosUsuario' => $datoUsuario,
            'puesto' => $puestoEmpleado,
            'niveleducativo' => $nivel,
            'grados' => $gradousuario,
            'template' => $template
        ];

        return view('Empleado/empleado', $data);
    }

    public function agregarGradoAcademico()
    {
        helper('form');
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }
        $user = session()->get('name');
        $token = session()->get('access_token');
        $datoUsuario = $this->modelo_user->findByCorreo($user['userPrincipalName']);
        $nivel = $this->modelo_nivel->obtenerNivel();
        $puestoEmpleado = $this->modelo_puesto_empleado->puestoAsignadoPorUsuario($this->userId);
        $gradosAcademicos = $this->model_grado_academico->obtenerGrado($this->userId);

        $gradousuario = [];
        if (!empty($gradosAcademicos)) {
            foreach ($gradosAcademicos as $grado) {

                $gradousuario[] = [
                    'nombre_nivel' => $grado['nombre_nivel'],
                    'nombre_grado' => $grado['nombre_grado'],
                    'programa_educativo' => $grado['programa_educativo'],
                    'siglas' => $grado['siglas'],
                    'fecha_creacion' => $grado['fecha_creacion']
                ];
            }
        }

        $data = [
            'user' => $user,
            'token' => $token,
            'niveleducativo' => $nivel,
            'datosUsuario' => $datoUsuario,

            'puesto' => $puestoEmpleado,
            'niveleducativo' => $nivel,
            'grados' => $gradousuario,
        ];
        return view('Empleado/editar_empleado', $data);
    }


    public function agregarInfoPersonal()
    {
        $this->agregarGradoAcademico();
        helper('form');

        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $nivel = $this->modelo_nivel->obtenerNivel();
        $rules = $this->model_grado_academico->reglasValidacion();
        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');

        $datoUsuario = $this->modelo_user->findByCorreo($user['userPrincipalName']);
        $puestoEmpleado = $this->modelo_puesto_empleado->puestoAsignadoPorUsuario($this->userId);

        $data = [
            'idnivel' => $this->request->getPost('nivel'),
            'idusuario' => $userId,
            'nombre_grado' => $this->request->getPost('grado'),
            'programa_educativo' => $this->request->getPost('programa_educativo'),
            'siglas' => $this->request->getPost('siglas'),
            'fecha_creacion' => $this->request->getPost('fecha_grado'),
        ];


        if (!$this->validate($rules)) {
            return view('Empleado/editar_empleado', [
                'validation' => $this->validator,
                'user' => $user,
                'token' => $token,
                'idusuario' => $userId,
                'datosUsuario' => $datoUsuario,
                'puesto' => $puestoEmpleado,
                'niveleducativo' => $nivel,
                'success' => null,


            ]);
        }


        if ($this->model_grado_academico->insertarGradoAcademico($data)) {

            session()->setFlashdata('success', 'Información personal guardada exitosamente.');
        } else {

            session()->setFlashdata('error', 'Hubo un problema al guardar la información. Por favor, intente nuevamente.');
        }


        return redirect()->to('/usuario/puesto');
    }
}
