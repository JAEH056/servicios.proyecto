<?php

namespace App\Controllers\Labs\MenuLaboratorista;

use App\Controllers\BaseController;
use App\Models\Labs\AsignarLaboratorioModel;
use App\Models\Labs\AsignaturaModel;
use App\Models\Labs\CarreraModel;
use App\Models\Labs\DiasInhabilesModel;
use App\Models\Labs\GrupoModel;
use App\Models\Labs\HorarioModel;
use App\Models\Labs\LaboratorioModel;
use App\Models\Labs\ReticulaModel;
use App\Models\Labs\SolicitudModel;
use App\Models\Labs\TipoUsoModel;
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
    protected $model_solicitud;
    protected $model_tipo_uso;
    protected $model_laboratorios_asignados_al_laboratorista;
    protected $helpers = ['form'];
    protected $validation;


    public function __construct()
    {
        $this->model_horario = model(HorarioModel::class);
        $this->model_laboratorio = model(LaboratorioModel::class);
        $this->model_dias_inhabiles = model(DiasInhabilesModel::class);
        $this->model_reticula = model(ReticulaModel::class);
        $this->model_grupo = model(GrupoModel::class);
        $this->model_asignaturas = model(AsignaturaModel::class);
        $this->model_carreras = model(CarreraModel::class);
        $this->model_usuario = model(UserModel::class);
        $this->model_solicitud = model(SolicitudModel::class);
        $this->model_tipo_uso = model(TipoUsoModel::class);
        $this->model_laboratorios_asignados_al_laboratorista = model(AsignarLaboratorioModel::class);
        $this->validation = \Config\Services::validation();
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
        $obtenerdatosusuario = $this->model_usuario->findByCorreo($user['userPrincipalName']);
        $laboratorista = $this->model_laboratorios_asignados_al_laboratorista->obtenerEncargadoDeLaboratorio($userId);

        //obtener id laboratorio uso posterior
        session()->set('idLaboratorio', $idLaboratorio);

        $periodos = $this->model_horario->obtenerHorariosPorLaboratorio($idLaboratorio);

        $carreras = $this->model_carreras->obtenerCarrera();
      

        $laboratorios = $this->model_laboratorio->obtenerLaboratorios();
        $tipos_uso_solicitudes_varias = $this->model_tipo_uso->obtenerTiposUso();
     //   $laboratorista = $this->model_laboratorios_asignados_al_laboratorista->obtenerEncargadoDeLaboratorio($user['userPrincipalName']);

        if (!$idLaboratorio && !empty($laboratorios)) {
            return redirect()->to(base_url("/usuario/horario/" . $laboratorios[0]['id']));
        }

        if (empty($periodos)) {
            return view('Labs/layouts/error_404_laboratorista', [
                'mensaje' => 'No se encontraron periodos para el laboratorio.',
                'user' => $user,
                'token' => $token,
                'idusuario' => $userId,
                'usuario' => $obtenerdatosusuario,
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
                   
                    'tipo_uso' => $tipos_uso_solicitudes_varias,
                    'user' => $user,
                    'token' => $token,
                    'idusuario' => $userId,
                    'usuario' => $obtenerdatosusuario,
                    'carreras'=>$carreras
                  

                ];
            }
            
             //print_r($data);
        }

        return view('Labs/layouts/horario_laboratorista', $data);
    }

    public function eventos()
    {
        $idLaboratorio = session()->get('idLaboratorio');

        // Obtener los semestre para cada laboratorio
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
                    'objetivo' => $datossolicitud['objetivo'],
                    'carrera' => $datossolicitud['carrera'],
                    'descripcion_tareas' => $datossolicitud['descripcion_tareas'],
                    'estado' => $datossolicitud['estado'],
                    'tipo_uso' => $datossolicitud['tipo_uso_varias']

                ];
                $solicitudes[] = [
                    'id'    => $datossolicitud['solicitud_id'],
                    'title' => $datossolicitud['titulo'],
                    'start' => $datossolicitud['fecha_hora_entrada'],
                    'end' => $datossolicitud['fecha_hora_salida'],
                    'raw' => $raw,

                ];
            }
        }
        $todosLosEventos = array_merge($eventos, $solicitudes);
        return $this->response->setJSON([
            'events' => $todosLosEventos,

        ]);
    }

    public function editarSolicitud($idSolicitud)
    {
        $solicitud = $this->model_solicitud->editar($idSolicitud);


        if ($solicitud) {

            return $this->response->setJSON([
                'status' => 'success',
                'solicitud' => $solicitud
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Solicitud no encontrada'
            ]);
        }
    }

    public function obtenerMateriascarrera(){
        $carreraId = $this->request->getGet('carreraId');
        
     
        if (!$carreraId) {
            return $this->response->setJSON(['error' => 'Parámetro carreraId no proporcionado'])->setStatusCode(400);
        }
      
        if (empty($carreraId)) {
            return $this->response->setJSON(['error' => 'ID de carrera no proporcionado'])->setStatusCode(400);
        }

        $asignaturas = [];
        $gruposcreados = [];
       
        $materias = $this->model_reticula->obtenerReticula($carreraId);
        if ($materias) {
          
            $asignaturas = array_map(function ($materia) {
                return [
                    'id' => $materia['id'],
                    'nombre_asignatura' => $materia['nombre_asignatura']
                ];
            }, $materias);
        }
        $grupos = $this->model_grupo->obtenerGruposPorCarrera($carreraId);
        if ($grupos) {
            $gruposcreados = array_map(function ($grupo) {
                return [
                    'id' => $grupo['id_grupo'],
                    'nombre' => $grupo['nombre_grupo']
                ];
            }, $grupos);
        }
        return $this->response->setJSON([
            'asignaturas' => $asignaturas,
            'grupos' => $grupos,
            'mensaje' => [
                'asignaturas' => empty($asignaturas) ? 'No se encontraron asignaturas' : 'Asignaturas encontradas',
                'grupos' => empty($gruposcreados) ? 'No se encontraron grupos' : 'Grupos encontrados'
            ]
        ]);
    }

    public function obtenerClaveMateria(){
        $asignaturaId = $this->request->getGet('asignaturaId');
       
        if (!$asignaturaId) {
            return $this->response->setJSON(['error' => 'Parámetro id asignatura no proporcionado'])->setStatusCode(400);
        }

        if (empty($asignaturaId)) {
            return $this->response->setJSON(['error' => 'ID de asignatura no proporcionado'])->setStatusCode(400);
        }

        $claveasignatura = $this->model_asignaturas->obtenerClaveMateria($asignaturaId);

        if ($claveasignatura) {
           
            $asignaturaclave = array_map(function ($clave) {
                return [
                    'claveasignatura' => $clave['clave_asignatura'],
                ];
            }, $claveasignatura);

            return $this->response->setJSON(['clave' => $asignaturaclave]);
        } else {

            return $this->response->setJSON(['error' => 'No se encontro la clave de la asignatura'], 404);
        }

    }
    public function actualizarSolicitud($idSolicitud)
    {
        $userId = session()->get('idusuario');
       
        
        $laboratorista = $this->model_laboratorios_asignados_al_laboratorista->obtenerEncargadoDeLaboratorio($userId);
        $idAsignarLaboratorio = $laboratorista[0]['id_asignar_laboratorio'];
        $data_solicitud=[
            'hora_fecha_entrada'=> $this->request->getPost('hora_fecha_entrada'),
            'hora_fecha_salida'=> $this->request->getPost('hora_fecha_salida'),
        ];
        $data_solicitud_varias=[
            'id_tipo_uso'=>$this->request->getPost('id_tipo_uso'),
            'descripcion_tareas'=>$this->request->getPost('descripcion_tareas'),
            'nombre_proyecto'=>$this->request->getPost('nombre_proyecto'),
        ];

        $data_solicitud_practica=[
            'nombre_practica'=> $this->request->getPost(''),
            'objetivo'=>$this->request->getPost(''),


        ];
        $data_clase=[
            'id_carrera'=>$this->request->getPost('carrera-id'),
            'id_asignatura'=>$this->request->getPost(''),
            'id_grupo'=>$this->request->getPost(''),

        ];

        $data_autorizacion=[
            'id_asignar_laboratorio' => $idAsignarLaboratorio,
            'estado'=>$this->request->getPost('autorizacion'),
            'observacion'=>$this->request->getPost('observaciones_varias'),
        ];
      
        $reglasSolicitudVarias = [
           'id_tipo_uso'=>[
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'El tipo de uso es obligatorio. Por favor seleccione una opción.',
                    
                ],
            ],
            'descripcion_tareas' => [
                'rules'  => 'required|max_length[255]|min_length[10]',
                'errors' => [
                    'required'   => 'La descricpcion de tareas es obligatoria.',
                    'max_length' => 'La descripcion  no puede tener más de 255 caracteres.',
                    'min_length' => 'El descripcion debe tener al menos 10 caracteres.',
                ],
            ],
            'nombre_proyecto' => [
                'rules'  => 'required|max_length[255]|min_length[10]',
                'errors' => [
                    'required'   => 'El nombre del proyecto es obligatorio.',
                    'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                    'min_length' => 'El nombre debe tener al menos 10 caracteres.',
                ],
            ],
            'observaciones_varias' => [
                'rules'  => 'required|max_length[255]|min_length[10]',
                'errors' => [
                    'required'   => 'La observacion es obligatoria.',
                    'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                    'min_length' => 'El nombre debe tener al menos 10 caracteres.',
                ],
            ],
        ];
        $reglasSolicitudPractica=[
            'nombre_practica'=> [
                'rules'=> 'required|max_length[255]|min_length[10]',
                'errors' => [
                    'required'   => 'El nombre de la practica es obligatorio.',
                    'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                    'min_length' => 'El nombre debe tener al menos 10 caracteres.',
                ],
            ],
        
            'objetivo'=>[
                'rules'=> 'required|max_length[255]|min_length[10]',
                'errors' => [
                    'required'   => 'El objetivo es obligatorio.',
                    'max_length' => 'El objetivo no puede tener más de 255 caracteres.',
                    'min_length' => 'El objetivo debe tener al menos 10 caracteres.',
                ],
            ],
            'id_carrera' => [
                'rules'    => 'required',
                'errors'=> [
                'required' => 'La carrera es obligatoria.',
                ],
            ],
            'id_asignatura' => [
                'rules'    => 'required',
                'errors' => [
                'required','La asignatura es obligatoria.',
                ],
            ],

            'id_grupo' => [
                'rules'=> 'required',
                'errors' =>[ 
                'required'=>'El grupo es obligatorio.',
                ],
            ],

            'observaciones_practicas' => [
                'rules'  => 'required|max_length[255]|min_length[10]',
                'errors' => [
                    'required'   => 'La observacion es obligatoria.',
                    'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                    'min_length' => 'El nombre debe tener al menos 10 caracteres.',
                ],
            ],
    ];
     $reglasSolicitudes= array_merge($reglasSolicitudVarias);

        if (!$this->validate($reglasSolicitudes)) {
            
            return $this->response->setJSON([
                
                'success' => false,
                'message' => 'Datos inválidos para la solicitud.',
                'errors' => $this->validation->getErrors(),
                'csrf' => csrf_hash(),
            ]);
        }
        
        
        $actualizar_solicitud=$this->model_solicitud->actualizarSolicitud($idSolicitud,$data_solicitud,$data_solicitud_varias,$data_solicitud_practica,$data_clase,$data_autorizacion);
    
        if(!$actualizar_solicitud){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se pudo actualizar los datos.',
                'csrf' => csrf_hash(),
            ]);
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Solicitud actualizada correctamente.',
            'csrf' => csrf_hash(),
        ]);
    }///gvdegw
}
