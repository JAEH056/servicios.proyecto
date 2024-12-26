<?php

namespace App\Controllers\Puestos;

use App\Controllers\BaseController;
use App\Models\PuestoEmpleado\GradoAcademicoModel;
use App\Models\PuestoEmpleado\NivelModel;
use App\Models\PuestoEmpleado\OrganigramaModel;
use App\Models\PuestoEmpleado\PuestoEmpleadoModel;
use App\Models\PuestoEmpleado\UserModel;

class Puesto extends BaseController
{
    protected $modelo_user;
    protected $modelo_organigrama;
    protected $modelo_puesto_empleado;
    protected $modelo_nivel;
    protected $model_grado_academico;

    public function __construct()
    {
        $this->modelo_user = model(UserModel::class);
        $this->modelo_organigrama = model(OrganigramaModel::class);
        $this->modelo_puesto_empleado = model(PuestoEmpleadoModel::class);
        $this->modelo_nivel = model(NivelModel::class);
        $this->model_grado_academico = model(GradoAcademicoModel::class);
    }

    public function plantillaVista()
    {
        helper('form');
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');
        $datoUsuario = $this->modelo_user->findByCorreo($user['userPrincipalName']);
        $jobTitle = session()->get('jobTitle');
        $nivel = $this->modelo_nivel->obtenerNivel();

        
        $this->asignarPuesto($userId, $jobTitle);
        
            $template = 'Labs/layouts/principal_laboratorista';
        

        $data = [
            'user' => $user,
            'token' => $token,
            'idusuario' => $userId,
            'datosUsuario' => $datoUsuario,
            'jobTitle' => $jobTitle,
            'niveleducativo' => $nivel,
           
            // 'template' => 'Labs/layouts/principal_laboratorista'
            'template'=>$template
        ];

        print_r($data);
        return view('Empleado/empleado', $data);
    }
    public function asignarPuesto($userId, $jobTitle)
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('idusuario')) {
            return redirect()->to('/oauth/login');
        }

        // Si no se ha asignado un título de trabajo, realizar búsqueda con un valor vacío
        if (empty($jobTitle) || $jobTitle === null) {
            $organigrama = $this->modelo_organigrama->buscarCargoNull();
        } else {
            // Buscar por el cargo específico
            $organigrama = $this->modelo_organigrama->buscarCargo($jobTitle);
        }

        // Si no se encuentra el organigrama correspondiente
        if (!$organigrama) {
            return redirect()->to('/usuario/puesto')->with('error', 'Cargo no encontrado en el organigrama.');
        }

        // Verificar si el idusuario está presente
        if (empty($userId)) {
            return redirect()->to('/usuario/puesto')->with('error', 'Usuario no encontrado.');
        }

        // Verificar si el puesto ya está asignado al usuario
        $puestoExistente = $this->modelo_puesto_empleado->puestoAsignadoPorUsuario($userId);

        if ($puestoExistente) {
            // Si ya existe un puesto activo, redirigir con un mensaje informando que el puesto ya está asignado
            //  return redirect()->to('/usuario/puesto')->with('error', 'El usuario ya tiene un puesto asignado.');
            return redirect()->to(base_url('/usuario/puesto/empleado'))->with('error', 'El usuario ya tiene un puesto asignado.');
        }

        // Datos para asignar el puesto
        $data = [
            'idusuario' => $userId,
            'idorganigrama' => $organigrama['idorganigrama'],
            'fecha_inicio' => date('Y-m-d H:i:s'),
            'fecha_fin' => null, // Fecha de fin puede ser NULL si el puesto está activo
        ];

        try {
            // Intentar insertar los datos en la base de datos
            $resultado = $this->modelo_puesto_empleado->asignarPuesto($data);

            // Verificar si la inserción fue exitosa
            if ($resultado) {
                return redirect()->to('/usuario/puesto')->with('success', 'Puesto asignado correctamente.');
            } else {
                return redirect()->to('/usuario/puesto')->with('error', 'Error al asignar el puesto.');
            }
        } catch (\Exception $e) {
            // En caso de error, mostrar el mensaje de la excepción
            return redirect()->to('/usuario/puesto')->with('error', 'Error al asignar el puesto: ' . $e->getMessage());
        }
    }

    public function agregarInfoPersonal()
    {
      
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        
        $nivel = $this->modelo_nivel->obtenerNivel();
        $rules = $this->model_grado_academico->reglasValidacion();
        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');
        $jobTitle = session()->get('jobTitle');
        $datoUsuario = $this->modelo_user->findByCorreo($user['userPrincipalName']);

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
                'jobTitle' => $jobTitle,
                'niveleducativo' => $nivel,
                'success' => null, 


            ]);
        }

       
        if ($this->model_grado_academico->insertarGradoAcademico($data)) {
           
            session()->setFlashdata('success', 'Información personal guardada exitosamente.');
        } else {
           
            session()->setFlashdata('error', 'Hubo un problema al guardar la información. Por favor, intente nuevamente.');
        }

        
        return redirect()->to('/empleado/editar');
    }
}
