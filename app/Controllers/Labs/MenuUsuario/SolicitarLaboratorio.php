<?php

namespace App\Controllers\Labs\MenuUsuario;

use App\Controllers\BaseController;
use App\Models\Labs\AsignaturaModel;
use App\Models\Labs\CarreraModel;
use App\Models\Labs\DiasInhabilesModel;
use App\Models\Labs\HorarioModel;
use App\Models\Labs\LaboratorioModel;
use App\Models\Labs\ReticulaModel;
use App\Models\Labs\TipoUsoModel;

class SolicitarLaboratorio extends BaseController
{
    protected $model_horario;
    protected $model_laboratorio;
    protected $model_dias_inhabiles;
    protected $model_tipos_uso;
    protected $model_carreras;
    protected $model_reticula;
    protected $model_asignaturas;
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
            return view('Labs/layouts/error_404', [
                'mensaje' => 'No se encontraron periodos para el laboratorio.',
                'user' => $user,
                'token' => $token,
                'idusuario' => $userId
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
            // Asegurarse de que la respuesta esté en formato JSON
            return $this->response->setJSON(['asignatura' => $asignaturas]);      // Responder con JSON
        } else {

            return $this->response->setJSON(['error' => 'No se encontraron asignaturas'], 404);
        }
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
        // $asignaturas = json_encode($materias);

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

            return $this->response->setJSON(['error' => 'No se la clave de la asignatura'], 404);
        }
    }

    public function enviarSolicitud()
    {
        // Obtener los valores de la sesión
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
            'idsemestre' => $semestreId
        ];

        print_r($data);

        return view('Labs/sarai', $data);
    }
}
