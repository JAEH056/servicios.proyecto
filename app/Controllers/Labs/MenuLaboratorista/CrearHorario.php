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

class CrearHorario extends BaseController
{
    protected $model_horario;
    protected $model_laboratorio;
    protected $model_dias_inhabiles;
    protected $model_reticula;
    protected $model_grupo;
    protected $model_asignaturas;
    protected $model_carreras;

    public function __construct()
    {
        $this->model_horario = model(HorarioModel::class);
        $this->model_laboratorio = model(LaboratorioModel::class);
        $this->model_dias_inhabiles = model(DiasInhabilesModel::class);
        $this->model_reticula = model(ReticulaModel::class);
        $this->model_grupo = model(GrupoModel::class);
        $this->model_asignaturas = model(AsignaturaModel::class);
        $this->model_carreras = model(CarreraModel::class);
      
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

        //obtener id laboratorio uso posterior
        session()->set('idLaboratorio', $idLaboratorio);

        $periodos = $this->model_horario->obtenerHorariosPorLaboratorio($idLaboratorio);

        //uso de semestre posterior
        session()->set('idsemestre', $periodos);

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
                ];
            }
            //  print_r($data);
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
        //horarios solicitados varias
        $horariosSolicitados = $this->model_horario->obtenerSolicitudesPorLaboratorio($idLaboratorio);
        $solicitudes = [];
        if (!empty($horariosSolicitados)) {
            foreach ($horariosSolicitados as $datossolicitud) {
                $raw = [
                    'fechaEnvio' => $datossolicitud['fecha_envio'],
                    'empleado' => $datossolicitud['correo'],
                    'grupo' => $datossolicitud['grupo'],
                    'clave_asignatura' => $datossolicitud['clave_asignatura'],
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
}
