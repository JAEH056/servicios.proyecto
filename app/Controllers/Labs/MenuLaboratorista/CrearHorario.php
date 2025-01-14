<?php

namespace App\Controllers\Labs\MenuLaboratorista;

use App\Controllers\BaseController;
use App\Models\Labs\AsignaturaModel;
use App\Models\Labs\CarreraModel;
use App\Models\Labs\DiasInhabilesModel;
use App\Models\Labs\GrupoModel;
use App\Models\Labs\HorarioModel;
use App\Models\Labs\LaboratorioModel;
use App\Models\Labs\ReticulaModel;
use App\Models\PuestoEmpleado\UserModel;

class CrearHorario extends BaseController
{
    protected $model_horario;
    protected $model_laboratorio;
    protected $model_dias_inhabiles;
    protected $model_reticula;
    protected $model_grupo;
    protected $model_asignaturas;
    protected $model_carreras;
    protected $model_usuario;
    protected $helpers = ['form'];


    public function __construct()
    {
        $this->model_horario = model(HorarioModel::class);
        $this->model_laboratorio = model(LaboratorioModel::class);
        $this->model_dias_inhabiles = model(DiasInhabilesModel::class);
        $this->model_reticula = model(ReticulaModel::class);
        $this->model_grupo = model(GrupoModel::class);
        $this->model_asignaturas = model(AsignaturaModel::class);
        $this->model_carreras = model(CarreraModel::class);
        $this->model_usuario= model(UserModel::class);
      
    }

    public function index($idLaboratorio = null)
    {
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }
        //datos del usuario se pasan a la vista
        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');
        //pasar el nombre del usurio a la vista
        $obtenerdatosusuario=$this->model_usuario->findByCorreo($user['userPrincipalName']);

        //obtener id laboratorio uso posterior
        session()->set('idLaboratorio', $idLaboratorio);

        $periodos = $this->model_horario->obtenerHorariosPorLaboratorio($idLaboratorio);

        $carreras = $this->model_carreras->obtenerCarrera();
        $laboratorios = $this->model_laboratorio->obtenerLaboratorios();

        if (!$idLaboratorio && !empty($laboratorios)) {
            return redirect()->to(base_url("/usuario/horario/" . $laboratorios[0]['id']));
        }

        if (empty($periodos)) {
            return view('Labs/layouts/error_404_laboratorista', [
                'mensaje' => 'No se encontraron periodos para el laboratorio.',
                'user' => $user,
                'token' => $token,
                'idusuario' => $userId,
                'usuario'=>$obtenerdatosusuario,
            ]);
        }

        $data = [];
        if (!empty($periodos)) {
            foreach ($periodos as $datosperiodo) {
                $data = [
                    'periodoJson' => json_encode([


                        'inicio' => $datosperiodo['inicio'],
                        'fin' => $datosperiodo['fin'],
                    ]),
                    'laboratorios' => $laboratorios,
                    'laboratorioSeleccionado' => $idLaboratorio,
                    'carreras' => $carreras,

                    'user' => $user,
                    'token' => $token,
                    'idusuario' => $userId,
                     'usuario'=>$obtenerdatosusuario
                ];
            }
              print_r($data);
        }

        return view('Labs/layouts/horario_laboratorista', $data);
    }

    public function eventos()
    {
        $idLaboratorio = session()->get('idLaboratorio');

        // Obtener los periodos
        $periodos = $this->model_horario->obtenerHorariosPorLaboratorio($idLaboratorio);

        // Verificar si no hay periodos
        if (empty($periodos)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No hay periodos disponibles para el laboratorio seleccionado.'
            ]);
        }

        foreach ($periodos as $datosperiodo) {
            if (isset($datosperiodo['inicio']) && isset($datosperiodo['fin'])) {
                $inicioPeriodo = $datosperiodo['inicio'];
                $finPeriodo = $datosperiodo['fin'];
            }
        }

        $diasInhabilesPeriodo = $this->model_dias_inhabiles->obtenerDiasInhabilesPorPeriodo($inicioPeriodo, $finPeriodo);

        // Procesar días inhábiles
        $eventos = [];
        if (!empty($diasInhabilesPeriodo)) {
            foreach ($diasInhabilesPeriodo as $datosevento) {
                $raw = [
                    'tipo_inhabil' => $datosevento['tipo_inhabil'],
                ];
                $eventos[] = [
                    'id'    => $datosevento['id'],
                    'title' => $datosevento['nombre'],
                    'start' => (new \DateTimeImmutable($datosevento['inicio']))->format('Y-m-d 00:00:00'),
                    'end'   => (new \DateTimeImmutable($datosevento['fin']))->format('Y-m-d 23:59:59'),
                    'raw'   => $raw,
                ];
            }
        }
        //horarios solicitados 
        $allsolicitudes = $this->model_horario->mostrarDatosSolicitud($idLaboratorio);
        $solicitudes = [];
        if (!empty($allsolicitudes)) {
            foreach ($allsolicitudes as $datossolicitud) {
                $raw = [
                    'fechaEnvio' => $datossolicitud['fecha_envio'],
                    'empleado' => $datossolicitud['correo'],
                    'grupo' => $datossolicitud['grupo'],
                    'clave_asignatura' => $datossolicitud['clave_asignatura'],
                    'objetivo'=>$datossolicitud['objetivo'],
                    'carrera'=>$datossolicitud['carrera'],
                    'descripcion_tareas'=>$datossolicitud['descripcion_tareas'],
                    'estado'=>$datossolicitud['estado'],
                    'tipo_uso'=>$datossolicitud['tipo_uso_varias']

                ];
                $solicitudes[] = [
                    'id'    => $datossolicitud['solicitud_id'],
                    'title' => $datossolicitud['titulo'],
                    'start' => $datossolicitud['fecha_hora_entrada'],
                    'end' => $datossolicitud['fecha_hora_salida'],
                    'raw'   => $raw,

                ];
            
        }
    }
        $todosLosEventos = array_merge($eventos, $solicitudes);
        return $this->response->setJSON([
            'events' => $todosLosEventos,

        ]);
    }  
    
    public function editarSolicitud($idSolicitud){
        
     
    }
}
