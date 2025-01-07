<?php

namespace App\Controllers\Labs\MenuUsuario;

use App\Controllers\BaseController;
use App\Models\Labs\AsignaturaModel;
use App\Models\Labs\AutorizacionModel;
use App\Models\Labs\CarreraModel;
use App\Models\Labs\DiasInhabilesModel;
use App\Models\Labs\GrupoModel;
use App\Models\Labs\HorarioModel;
use App\Models\Labs\LaboratorioModel;
use App\Models\Labs\ReticulaModel;
use App\Models\Labs\SolicitudesVariasModel;
use App\Models\Labs\SolicitudModel;
use App\Models\Labs\TipoUsoModel;
use App\Models\PuestoEmpleado\PuestoEmpleadoModel;
use App\Models\PuestoEmpleado\UserModel;

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
    protected $helpers = ['form'];

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
        session()->set('idLaboratorio', $idLaboratorio);

        $periodos = $this->model_horario->obtenerHorariosPorLaboratorio($idLaboratorio);
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
        } else {
            foreach ($periodos as $datosperiodo) {
                if (isset($datosperiodo['inicio']) && isset($datosperiodo['fin'])) {
                    $inicioPeriodo = $datosperiodo['inicio'];
                    $finPeriodo = $datosperiodo['fin'];
                }
            }
        }

        // Obtener días inhábiles para el periodo seleccionado
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

        $todosLosEventos = array_merge($eventos);

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
                    'events' => json_encode($todosLosEventos),
                    'user' => $user,
                    'token' => $token,
                    'idusuario' => $userId,
                    'usuario' => $obtenedatosUsuario,
                    'tipouso' => $tipos_uso_solicitudes_varias,
                    'carreras' => $carreras,

                ];
            }
            print_r($data);
        }

        return view('Labs/layouts/horario_docente', $data);
    }


    public function obtenerMateriasCarrera()
    {
        $carreraId = $this->request->getGet('carreraId');
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

        $userId = session()->get('idusuario');
        $idLaboratorio = session()->get('idLaboratorio');
        $carreraId = session()->get('idCarrera');
        $asignaturaId = session()->get('idasignatura');
        $idSemestre = session()->get('idsemestre');

        // Verificar si 'idsemestre' es un array y tiene elementos
        if (isset($idSemestre) && is_array($idSemestre) && isset($idSemestre[0]['semestre_id'])) {
            // Obtener el semestre_id del primer elemento
            $semestreId = $idSemestre[0]['semestre_id'];  // Acceder al primer elemento del array 'idsemestre'
        } else {

            $semestreId = null;
        }

        $data = [
            'idlaboratorio' => $idLaboratorio,
            'idcarrera' => $carreraId,
            'idasignatura' => $asignaturaId,
            'idsemestre' => $semestreId,
            'idusuario' => $userId,
        ];

        print_r($data);

        return view('Labs/sarai', $data);
    }

    // public function enviarSolicitudVarias()
    // {
    //     // Obtener los datos del formulario
    //     $tiposolicitud = $this->request->getPost('event-selector-solicitud');
    //     $idLaboratorio = session()->get('idLaboratorio');
    //     $userId = session()->get('idusuario');

    //     // Obtener el puesto asignado al usuario
    //     $puestoempleado = $this->model_puesto_empleado->puestoAsignadoPorUsuario($userId);

    //     if (!$puestoempleado) {
    //         return redirect()->back()->with('error', 'No se pudo determinar el puesto del empleado.');
    //     }

    //     // Obtener el ID del puesto
    //     $idPuesto = $puestoempleado['idpuesto'];

    //     // Verificar el tipo de solicitud
    //     if ($tiposolicitud === 'varias') {
    //         // Datos para la tabla de solicitud
    //         $dataSolicitud = [
    //             'id_laboratorio' => $idLaboratorio,
    //             'id_puesto_empleado' => $idPuesto,
    //             'hora_fecha_entrada' => $this->request->getPost('datepicker-start-input1'),
    //             'hora_fecha_salida' => $this->request->getPost('datepicker-end-input2'),
    //         ];

    //         // Iniciar transacción
    //         $db = db_connect('laboratorios');
    //         $db->transStart();

    //         // Insertar en la tabla solicitud
    //         if (!$this->model_solicitud->insert($dataSolicitud)) {
    //             $db->transRollback();
    //             log_message('debug', 'No se pudo guardar la solicitud.');
    //             return redirect()->back()->with('error', 'No se pudo guardar la solicitud.');
    //         }

    //         // Obtener el ID de la solicitud insertada
    //         $idSolicitud = $this->model_solicitud->getInsertID();

    //         // Verificar si se obtuvo un ID de solicitud válido
    //         if (!$idSolicitud) {
    //             log_message('error', 'No se obtuvo el ID de la solicitud.');
    //             $db->transRollback();
    //             return redirect()->back()->with('error', 'No se pudo obtener el ID de la solicitud.');
    //         }

    //         log_message('debug', 'ID de solicitud insertada: ' . $idSolicitud);

    //         // Datos para la tabla solicitudes_varias
    //         $dataSolicitudesVarias = [
    //             'id_solicitud' => $idSolicitud,  // Usar el ID de solicitud generado
    //             'id_tipo_uso' => $this->request->getPost('id_tipo_uso'),
    //             'descripcion_tareas' => $this->request->getPost('descripcion_tareas'),
    //             'nombre_proyecto' => $this->request->getPost('nombre_proyecto'),
    //         ];

    //         if (!$this->model_solicitudes_varias->validate($dataSolicitudesVarias)) {
    //             $errors = $this->model_solicitudes_varias->errors();
    //             return redirect()->back()->withInput()->with('errors', $errors);
    //         }


    //         // Verificar que los datos sean válidos antes de la inserción
    //         log_message('debug', 'Datos para solicitudes_varias: ' . print_r($dataSolicitudesVarias, true));

    //         // Intentar insertar en la tabla solicitudes_varias
    //         if (!$this->model_solicitudes_varias->insert($dataSolicitudesVarias)) {
    //             $db->transRollback();  // Revierte la transacción si la inserción falla

    //             // Registrar el error
    //             $db_error = $db->error();
    //             log_message('error', 'Error al insertar en solicitudes_varias: ' . print_r($db_error, true));

    //             return redirect()->back()->with('error', 'No se pudo guardar las solicitudes varias.');
    //         }

    //         // Verificar el estado de la transacción
    //         if ($db->transStatus() === false) {
    //             log_message('debug', 'Ocurrió un error al procesar la solicitud.');
    //             return redirect()->back()->with('error', 'Ocurrió un error durante la transacción.');
    //         }

    //         // Completar la transacción
    //         $db->transComplete();

    //         // Redirigir a la página de éxito
    //         if (!$idLaboratorio && !empty($laboratorios)) {
    //             return redirect()->to('/usuario/empleado/horario/')->with('success', 'Solicitud enviada correctamente.' . $laboratorios[0]['id']);
    //         }
    //         // return redirect()->to('/usuario/empleado/horario/')->with('success', 'Solicitud enviada correctamente.');
    //     }

    //     // Si el tipo de solicitud no es "varias", retornar un error
    //     return redirect()->back()->with('error', 'Tipo de solicitud no válido.');
    // }
    public function enviarSolicitudVarias()
    {

        // Obtener los datos del formulario
        $tiposolicitud = $this->request->getPost('event-selector-solicitud');
        $idLaboratorio = session()->get('idLaboratorio');
        $userId = session()->get('idusuario');

        // Obtener el puesto asignado al usuario
        $puestoempleado = $this->model_puesto_empleado->puestoAsignadoPorUsuario($userId);

        if (!$puestoempleado) {
            // Responder con un error en formato JSON
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se pudo determinar el puesto del empleado.',
            ]);
        }

        // Obtener el ID del puesto
        $idPuesto = $puestoempleado['idpuesto'];

        // Verificar el tipo de solicitud
        if ($tiposolicitud === 'varias') {
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
                'id_puesto_empleado' => $idPuesto,
                'hora_fecha_entrada' => $this->request->getPost('datepicker-start-input1'),
                'hora_fecha_salida' => $this->request->getPost('datepicker-end-input2'),
            ];

            // Iniciar transacción
            $db = db_connect('laboratorios');
            $db->transStart();

            // Insertar en la tabla solicitud
            if (!$this->model_solicitud->insert($dataSolicitud)) {
                $db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'csrf' => csrf_hash(),
                    'message' => 'No se pudo guardar la solicitud.',
                ]);
            }

            // Obtener el ID de la solicitud insertada
            $idSolicitud = $this->model_solicitud->getInsertID();

            // Verificar si se obtuvo un ID de solicitud válido
            if (!$idSolicitud) {
                $db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se pudo obtener el ID de la solicitud.',
                ]);
            }

            // Agregar el ID de solicitud a los datos de solicitudes_varias
            $dataSolicitudesVarias['id_solicitud'] = $idSolicitud;

            // Intentar insertar en la tabla solicitudes_varias
            if (!$this->model_solicitudes_varias->insert($dataSolicitudesVarias)) {
                $db->transRollback();
                $db_error = $db->error();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se pudo guardar las solicitudes varias.',
                    'db_error' => $db_error,
                ]);
            }

            // Verificar el estado de la transacción
            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ocurrió un error durante la transacción.',
                ]);
            }

            // Completar la transacción
            $db->transComplete();

            // Responder con éxito en formato JSON
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Solicitud enviada correctamente.',
                'csrf' => csrf_hash(),

            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Tipo de solicitud no válido.',
            'csrf' => csrf_hash(),
        ]);
    }
}
