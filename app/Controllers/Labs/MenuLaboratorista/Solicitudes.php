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
use App\Clases\Solicitud;
use App\Clases\SolicitudVaria;
use App\Clases\SolicitudPractica;

class Solicitudes extends BaseController
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

    public function __construct(){
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
    
        //obtener id laboratorio uso posterior
        session()->set('idLaboratorio', $idLaboratorio);

        $periodos = $this->model_horario->obtenerHorariosPorLaboratorio($idLaboratorio);

        $carreras = $this->model_carreras->obtenerCarrera();
      

        $laboratorios = $this->model_laboratorio->obtenerLaboratorios();
        $tipos_uso_solicitudes_varias = $this->model_tipo_uso->obtenerTiposUso();
   
        
        if (!$idLaboratorio && !empty($laboratorios)) {
            return redirect()->to(base_url("/usuario/horario/laboratorio/" . $laboratorios[0]['id']));
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
            
        }

        return view('Labs/layouts/horario_laboratorista_prueba', $data);
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

        $diasInhabiles= $this->model_dias_inhabiles->obtenerDiasInhabiles();

        // Procesar días inhábiles
        $eventos = [];
        if (!empty($diasInhabiles)) {
            foreach ($diasInhabiles as $datosevento) {
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
            foreach ($allsolicitudes as $solicitud) {
                $raw = [
                    'fechaEnvio' => $solicitud['fecha_envio'],
                    'empleado' => $solicitud['correo'],
                    'grupo' => $solicitud['grupo'],
                    'clave_asignatura' => $solicitud['clave_asignatura'],
                    'objetivo' => $solicitud['objetivo'],
                    'carrera' => $solicitud['carrera'],
                    'descripcion_tareas' => $solicitud['descripcion_tareas'],
                    'estado' => $solicitud['estado'],
                    'tipo_uso' => $solicitud['tipo_uso_varias']

                ];
                $solicitudes[] = [
                    'id'    => $solicitud['solicitud_id'],
                    'title' => $solicitud['titulo'],
                    'start' => $solicitud['fecha_hora_entrada'],
                    'end' => $solicitud['fecha_hora_salida'],
                    'raw' => $raw,

                ];
            }
        }
        $todosLosEventos = array_merge($eventos, $solicitudes);
        return $this->response->setJSON([
            'events' => $todosLosEventos,

        ]);
    }
    public function editarSolicitud(int $idSolicitud): \CodeIgniter\HTTP\Response {
      
        $solicitud = $this->buscarSolicitud($idSolicitud);
        
        
       // echo $solicitud ;
        //ob_start();
      //  print_r($solicitud);
       // $s = ob_get_flush();

      // echo "<script>console.log(`$s);</script>"; 
     //  die;

        if ($solicitud) {
            return $this->response->setJSON([
                'status' => 'success',
                'solicitud' => $solicitud,  
            ]);
        } else {
         
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Solicitud no encontrada',
            ]);
        }
    }
    protected function buscarSolicitud(int $idSolicitud): ?Solicitud {
        $solicitudes = $this->model_solicitud->obtenerSolicitud($idSolicitud);
        foreach($solicitudes as $solicitud) {
            $dbFechaEntrada= new \DateTimeImmutable($solicitud['hora_fecha_entrada']);



            switch ($solicitud['tipo_solicitud']) {
                case 'varias':
                    return new SolicitudVaria(
                        $solicitud['nombre_proyecto'],  
                        $solicitud['correo'],  
                        new \DateTimeImmutable($solicitud['hora_fecha_entrada']),
                        new \DateTimeImmutable($solicitud['hora_fecha_salida']),  
                        new \DateTimeImmutable($solicitud['fecha_solicitud']) ,
                        (int)$solicitud['estado'],
                        $solicitud['id_tipo_uso'],
                        $solicitud['descripcion_tareas'],
                        (int)$solicitud['id_solicitud'],
                    );
                case 'practica':
                    return new SolicitudPractica(
                        $solicitud['nombre_proyecto'],  
                        $solicitud['correo'],  
                        new \DateTimeImmutable($solicitud['hora_fecha_entrada']), 
                        new \DateTimeImmutable($solicitud['hora_fecha_salida']),  
                        new \DateTimeImmutable($solicitud['fecha_solicitud']) ,
                        (int)$solicitud['estado'],
                        ['carrera'=>$solicitud['id_carrera'],'grupo'=>$solicitud['id_grupo']],
                        $solicitud['objetivo'],
                        (int)$solicitud['id_solicitud'],
                    );
                default:
                    throw new \Exception("Tipo de solicitud desconocido");
            }
        }
        return null;
    }
    public function actualizarSolicitudVarias($idSolicitud){
        $userId = session()->get('idusuario');
        $data_solicitud=[
            'hora_fecha_entrada'=> $this->request->getPost('hora_fecha_entrada'),
            'hora_fecha_salida'=> $this->request->getPost('hora_fecha_salida'),
        ];
        $data_solicitud_varias=[
            'id_tipo_uso'=>$this->request->getPost('id_tipo_uso'),
            'descripcion_tareas'=>$this->request->getPost('descripcion_tareas'),
            'nombre_proyecto'=>$this->request->getPost('nombre_proyecto'),
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
    }
    
}
    
