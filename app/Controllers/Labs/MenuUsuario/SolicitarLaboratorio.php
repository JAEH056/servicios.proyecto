<?php

namespace App\Controllers\Labs\MenuUsuario;

use App\Controllers\BaseController;
use App\Models\Labs\AsignaturaModel;
use App\Models\Labs\AutorizacionModel;
use App\Models\Labs\CarreraModel;
use App\Models\Labs\ClaseModel;
use App\Models\Labs\DiasInhabilesModel;
use App\Models\Labs\GrupoModel;
use App\Models\Labs\HorarioModel;
use App\Models\Labs\LaboratorioModel;
use App\Models\Labs\ReticulaModel;
use App\Models\Labs\SolicitudesPracticasModel;
use App\Models\Labs\SolicitudesVariasModel;
use App\Models\Labs\SolicitudModel;
use App\Models\Labs\TipoUsoModel;
use App\Models\PuestoEmpleado\PuestoEmpleadoModel;
use App\Models\PuestoEmpleado\UserModel;
use Config\Services;

class SolicitarLaboratorio extends BaseController
{
    protected $model_horario;
    protected $model_laboratorio;
    protected $model_dias_inhabiles;
    protected $model_tipos_uso;
    protected $model_carreras;
    protected $model_reticula;
    protected $model_asignaturas;
    protected $model_grupo;
    protected $model_usuario;
    protected $model_puesto_empleado;
    protected $model_solicitud;
    protected $model_solicitudes_varias;
    protected $model_autorizacion;
    protected $model_solicitudes_practicas;
    protected $model_clase;
    protected $helpers = ['form'];
    protected $validation;

    public function __construct()
    {

        $this->model_horario = model(HorarioModel::class);
        $this->model_laboratorio = model(LaboratorioModel::class);
        $this->model_dias_inhabiles = model(DiasInhabilesModel::class);
        $this->model_tipos_uso = model(TipoUsoModel::class);
        $this->model_carreras = model(CarreraModel::class);
        $this->model_reticula = model(ReticulaModel::class);
        $this->model_asignaturas = model(AsignaturaModel::class);
        $this->model_grupo = model(GrupoModel::class);
        $this->model_usuario = model(UserModel::class);
        $this->model_puesto_empleado = model(PuestoEmpleadoModel::class);
        $this->model_solicitud = model(SolicitudModel::class);
        $this->model_solicitudes_varias = model(SolicitudesVariasModel::class);
        $this->model_autorizacion = model(AutorizacionModel::class);
        $this->model_solicitudes_practicas = model(SolicitudesPracticasModel::class);
        $this->model_clase = model(ClaseModel::class);
        $this->validation = Services::validation();
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
        $obtenedatosUsuario = $this->model_usuario->findByCorreo($user['userPrincipalName']);
        //obtener id laboratorio uso posterior
        session()->set('idLaboratorio', $idLaboratorio);

        $periodos = $this->model_horario->obtenerHorariosPorLaboratorio($idLaboratorio);

        //uso de semestre posterior
        session()->set('idsemestre', $periodos);

        $laboratorios = $this->model_laboratorio->obtenerLaboratorios();
        $tipos_uso_solicitudes_varias = $this->model_tipos_uso->obtenerTiposUso();
        $carreras = $this->model_carreras->obtenerCarrera();


        if (!$idLaboratorio && !empty($laboratorios)) {
            return redirect()->to(base_url("/usuario/empleado/horario/" . $laboratorios[0]['id']));
        }

        if (empty($periodos)) {
            return view('Labs/layouts/error_404_docente', [
                'mensaje' => 'No se encontraron periodos para el laboratorio.',
                'user' => $user,
                'token' => $token,
                'idusuario' => $userId,
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

                    'user' => $user,
                    'token' => $token,
                    'idusuario' => $userId,
                    'usuario' => $obtenedatosUsuario,
                    'tipouso' => $tipos_uso_solicitudes_varias,
                    'carreras' => $carreras,


                ];
            }
          //  print_r($data);
        }

        return view('Labs/layouts/horario_docente', $data);
    }

    public function eventosLaboratorio()
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
        //horarios solicitados varias
        $horariosSolicitados = $this->model_horario->obtenerSolicitudesPorLaboratorio($idLaboratorio);
        $solicitudvarias = [];
        if (!empty($horariosSolicitados)) {
            foreach ($horariosSolicitados as $datossolicitudvarias) {
                $raw = [
                    'fechaEnvio'=>$datossolicitudvarias['fecha_envio'],
                    'empleado' => $datossolicitudvarias['correo'],
                    'grupo'=>$datossolicitudvarias['grupo'],
                    'clave_asignatura'=>$datossolicitudvarias['clave_asignatura'],
                ];
                $solicitudvarias[] = [
                    'id'    => $datossolicitudvarias['solicitud_id'],
                    'title' => $datossolicitudvarias['titulo'],
                    'start' => $datossolicitudvarias['fecha_hora_entrada'],
                    'end' => $datossolicitudvarias['fecha_hora_salida'],
                    'raw'   => $raw,

                ];
            }
        }
        $todosLosEventos = array_merge($eventos, $solicitudvarias);
        return $this->response->setJSON([
            'events' => $todosLosEventos,

        ]);
    }

    public function obtenerMateriasCarrera()
    {
        $carreraId = $this->request->getGet('carreraId');
        
        // $data = ['carreraId' => $carreraId];
    
        // // Devolver el array como una respuesta JSON
        // return $this->response->setJSON($data);  
        session()->set('idCarrera', $carreraId);

        // Verificar si 'carreraId' está presente
        if (!$carreraId) {
            return $this->response->setJSON(['error' => 'Parámetro carreraId no proporcionado'])->setStatusCode(400);
        }

        // Validar que el ID de la carrera no esté vacío
        if (empty($carreraId)) {
            return $this->response->setJSON(['error' => 'ID de carrera no proporcionado'])->setStatusCode(400);
        }

        // Inicializar las variables de asignaturas y grupos
        $asignaturas = [];
        $gruposcreados = [];

        // Obtener las asignaturas del modelo
        $materias = $this->model_reticula->obtenerReticula($carreraId);

        // Verificar si se encontraron materias
        if ($materias) {
            // Crear un nuevo arreglo con los ids y los nombres de las asignaturas
            $asignaturas = array_map(function ($materia) {
                return [
                    'id' => $materia['id'], // Asumiendo que el id de la asignatura está en la clave 'id'
                    'nombre_asignatura' => $materia['nombre_asignatura']
                ];
            }, $materias);
        }

        // Obtener los grupos por carrera
        $grupos = $this->model_grupo->obtenerGruposPorCarrera($carreraId);
        if ($grupos) {
            $gruposcreados = array_map(function ($grupo) {
                return [
                    'id' => $grupo['id_grupo'],
                    'nombre' => $grupo['nombre_grupo'] // Asegúrate de que el campo 'nombre_grupo' exista
                ];
            }, $grupos);
        }

        // Devolver la respuesta en formato JSON
        return $this->response->setJSON([
            'asignaturas' => $asignaturas,
            'grupos' => $grupos,
            'mensaje' => [
                'asignaturas' => empty($asignaturas) ? 'No se encontraron asignaturas' : 'Asignaturas encontradas',
                'grupos' => empty($gruposcreados) ? 'No se encontraron grupos' : 'Grupos encontrados'
            ]
        ]);
    }

    public function obtenerClavePorMateria()
    {
        $asignaturaId = $this->request->getGet('asignaturaId');
        session()->set('idasignatura', $asignaturaId);

        // Verificar si 'carreraId' está presente
        if (!$asignaturaId) {
            return $this->response->setJSON(['error' => 'Parámetro id asignatura no proporcionado'])->setStatusCode(400);
        }

        if (empty($asignaturaId)) {
            return $this->response->setJSON(['error' => 'ID de asignatura no proporcionado'])->setStatusCode(400);
        }

        $claveasignatura = $this->model_asignaturas->obtenerClaveMateria($asignaturaId);

        // Verificar si se encontraron materias
        if ($claveasignatura) {
            // Crear un nuevo arreglo con los ids y los nombres de las asignaturas
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

    public function enviarSolicitud()
    {

        // Obtener los datos del formulario
        $tiposolicitud = $this->request->getPost('event-selector-solicitud');
        $idLaboratorio = session()->get('idLaboratorio');
        $userId = session()->get('idusuario');

        // Obtener el puesto asignado al usuario
        $puestoempleado = $this->model_puesto_empleado->puestoAsignadoPorUsuario($userId);

        if (!$puestoempleado) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se pudo determinar el puesto del empleado.',
                'csrf' => csrf_hash(),
            ]);
        }

        // Verificar el tipo de solicitud con un switch
        switch ($tiposolicitud) {
            case 'varias':
                // Validación de los datos de la tabla solicitudes_varias antes de insertar nada
                $dataSolicitudesVarias = [
                    'id_tipo_uso' => $this->request->getPost('id_tipo_uso'),
                    'descripcion_tareas' => $this->request->getPost('descripcion_tareas'),
                    'nombre_proyecto' => $this->request->getPost('nombre_proyecto'),
                ];

                if (!$this->model_solicitudes_varias->validate($dataSolicitudesVarias)) {
                    $errors = $this->model_solicitudes_varias->errors();
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Datos inválidos para la solicitud varias.',
                        'errors' => $errors,
                        'csrf' => csrf_hash(),
                    ]);
                }

                // Datos para la tabla de solicitud
                $dataSolicitud = [
                    'id_laboratorio' => $idLaboratorio,
                    'id_puesto_empleado' => $puestoempleado['idpuesto'],
                    'hora_fecha_entrada' => $this->request->getPost('datepicker-start-input1'),
                    'hora_fecha_salida' => $this->request->getPost('datepicker-end-input2'),
                ];

                // Insertar la solicitud y obtener el ID de la solicitud
                $idSolicitud = $this->model_solicitud->insertarSolicitud($dataSolicitud);

                // Verificar si se obtuvo un ID de solicitud válido
                if ($idSolicitud === false || !$idSolicitud) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'No se pudo guardar la solicitud.',
                        'csrf' => csrf_hash(),
                    ]);
                }

                // Insertar las solicitudes varias
                $dataSolicitudesVarias['id_solicitud'] = $idSolicitud;
                $solicitudesVarias = $this->model_solicitudes_varias->insertarSolicitudeVarias($dataSolicitudesVarias);

                // Verificar si la inserción fue exitosa
                if (!$solicitudesVarias) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'No se pudo guardar las solicitudes varias.',
                        'csrf' => csrf_hash(),
                    ]);
                }

                // Insertar autorización
                $dataAutorizaciones = [
                    'id_solicitud' => $idSolicitud,
                    'estado' => 0, // Estado inicial
                ];

                $autorizacionsolicitud = $this->model_autorizacion->insertarAutorizacion($dataAutorizaciones);

                // Verificar si la inserción en autorizacion fue exitosa
                if (!$autorizacionsolicitud) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'No se pudo guardar la autorización.',
                        'csrf' => csrf_hash(),
                    ]);
                }

                // Responder con éxito
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Solicitud enviada correctamente.',
                    'csrf' => csrf_hash(),
                ]);
                break;

            case 'practicas':
               
                // Ejemplo de datos recibidos
                $dataPractica = [
                    
                    'nombre_practica' => $this->request->getPost('nombre_practica'),
                    'objetivo' => $this->request->getPost('objetivo'),
                ];

                $dataClase = [
                    'id_carrera' => $this->request->getPost('id_carrera'),
                    'id_asignatura' => $this->request->getPost('id_asignatura'),
                    'id_grupo' => $this->request->getPost('id_grupo'),
                ];

                // Reglas de validación para los datos de la práctica
                $validationRulesPractica = [
                    'nombre_practica' => 'required|max_length[255]|min_length[10]',
                    'objetivo' => 'required|max_length[255]|min_length[10]',
                ];

                // Mensajes de validación para los datos de la práctica
                $validationMessagesPractica = [
                    'nombre_practica' => [
                        'required' => 'El nombre de la práctica es obligatorio.',
                        'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                        'min_length' => 'El nombre debe tener al menos 10 caracteres.',
                    ],
                    'objetivo' => [
                        'required' => 'El objetivo es obligatorio.',
                        'max_length' => 'El objetivo no puede tener más de 255 caracteres.',
                        'min_length' => 'El objetivo debe tener al menos 10 caracteres.',
                    ],
                ];

                // Reglas de validación para los datos de la clase
                $validationRulesClase = [
                    'id_carrera' => 'required|is_natural_no_zero',
                    'id_asignatura' => 'required|is_natural_no_zero',
                    'id_grupo' => 'required|is_natural_no_zero',
                ];

                // Mensajes de validación para los datos de la clase
                $validationMessagesClase = [
                    'id_carrera' => [
                        'required' => 'La carrera es obligatoria.',
                        'is_natural_no_zero' => 'La carrera seleccionada no es válida.',
                    ],
                    'id_asignatura' => [
                        'required' => 'La asignatura es obligatoria.',
                        'is_natural_no_zero' => 'La asignatura seleccionada no es válida.',
                    ],
                    'id_grupo' => [
                        'required' => 'El grupo es obligatorio.',
                        'is_natural_no_zero' => 'El grupo seleccionado no es válido.',
                    ],
                ];

                // Combina las reglas de validación
                $validationRules = array_merge($validationRulesPractica, $validationRulesClase);

                // Combina los mensajes de validación
                $validationMessages = array_merge($validationMessagesPractica, $validationMessagesClase);

                // Establece las reglas de validación
                $this->validation->setRules($validationRules, $validationMessages);

                // Valida los datos recibidos
                if (!$this->validation->run(array_merge($dataPractica, $dataClase))) {
                    // Si la validación falla, devolver los errores
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Datos inválidos.',
                        'errors' => $this->validation->getErrors(),
                        'csrf' => csrf_hash(),
                    ]);
                }

                $idClase = $this->model_clase->insertarClase($dataClase);
                // Verificar si se obtuvo un ID de solicitud válido
                if ($idClase === false || !$idClase) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'No se pudo guardar La clase.',
                        'csrf' => csrf_hash(),
                    ]);
                }

                $dataSolicitud = [
                    'id_laboratorio' => $idLaboratorio,
                    'id_puesto_empleado' => $puestoempleado['idpuesto'],
                    'hora_fecha_entrada' => $this->request->getPost('datepicker-start-input1'),
                    'hora_fecha_salida' => $this->request->getPost('datepicker-end-input2'),
                ];

                // Insertar la solicitud y obtener el ID de la solicitud
                $idSolicitud = $this->model_solicitud->insertarSolicitud($dataSolicitud);

                // Verificar si se obtuvo un ID de solicitud válido
                if ($idSolicitud === false || !$idSolicitud) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'No se pudo guardar la solicitud.',
                        'csrf' => csrf_hash(),
                    ]);
                }


               

                // Insertar las solicitudes varias
                $dataPractica['id_solicitud'] = $idSolicitud;
                $dataPractica['id_clase'] = $idClase;
                $solicitudesPracticas = $this->model_solicitudes_practicas->insertarPracticas($dataPractica);

                // Verificar si la inserción fue exitosa
                if (!$solicitudesPracticas) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'No se pudo guardar las solicitudes practicas.',
                        'csrf' => csrf_hash(),
                    ]);
                }

                // Insertar autorización
                $dataAutorizaciones = [
                    'id_solicitud' => $idSolicitud,
                    'estado' => 0, // Estado inicial
                ];

                $autorizacionsolicitud = $this->model_autorizacion->insertarAutorizacion($dataAutorizaciones);

                // Verificar si la inserción en autorizacion fue exitosa
                if (!$autorizacionsolicitud) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'No se pudo guardar la autorización.',
                        'csrf' => csrf_hash(),
                    ]);
                }

                // Responder con éxito
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Solicitud enviada correctamente.',
                    'csrf' => csrf_hash(),
                ]);

                break;
        }
    }
}
