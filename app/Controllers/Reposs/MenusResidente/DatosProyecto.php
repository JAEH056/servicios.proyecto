<?php

namespace App\Controllers\Reposs\MenusResidente;

use App\Models\PuestoEmpleado\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Reposs\EmpresaModel;
use App\Models\Reposs\ProyectoModel;
use App\Models\Reposs\AsesorExternoModel;
use App\Models\Reposs\AsesorInternoModel;
use App\Models\Reposs\ResidenteModel;
use App\Models\Reposs\SectorModel;
use App\Models\Reposs\RamoModel;

class DatosProyecto extends ResourceController
{
    protected $asesorExterno;
    protected $asesorInterno;
    protected $usuario;
    protected $residente;
    protected $proyecto;
    protected $empresa;
    protected $userId;
    protected $sector;
    protected $ramo;
    public function __construct()
    {
        $this->asesorInterno = new AsesorInternoModel();
        $this->asesorExterno = new AsesorExternoModel();
        $this->usuario = new UserModel();
        $this->residente = new ResidenteModel();
        $this->proyecto = new ProyectoModel();
        $this->empresa = new EmpresaModel();
        $this->sector = new SectorModel();
        $this->ramo = new RamoModel();
        $this->userId = session()->get('idusuario');
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        //Se cargan los datos de la empresa existente (si la hay) en la vista de proyecto
        $datosEmpresa = $this->empresa->getEmpresaByUserId($this->userId);
        $empresas = $this->proyecto->getProyectoEmpresasByUserId($this->userId);
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/datosProyecto', [
            'user' => $user,
            'token' => $token,
            'idusuario' => $this->userId,
            'datosEmpresa' => $datosEmpresa,
            'empresas' => $empresas,
        ]); // Se agregan los datos a la vista
    }

    /**
     * Vista de la seccion: Asesor Interno
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function busquedaAsesor()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }
        $nombreProyectos = $this->proyecto->getProyectoEmpresasByUserId($this->userId);
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/datosAsesorInterno', [
            'user' => $user,
            'token' => $token,
            'idusuario' => $this->userId,
            'nombreProyectos' => $nombreProyectos,
        ]);
    }

    /**
     *  Barra de busqueda seccion: Asesor Interno
     */
    public function buscar()
    {
        $nombreCompleto = $this->request->getVar('nombre');
        // Valida la entra de datos
        if (empty($nombreCompleto)) {
            return $this->response->setJSON([]);
        }
        // Realiza la busqueda
        $resultados = $this->usuario->buscarAsesoresPorNombreCompleto($nombreCompleto);
        // Regresa los resultados como JSON
        return $this->response->setJSON($resultados);
    }

    public function createAsesorInter($idusuario)
    {
        $post = $this->request->getPost([
            'idproyecto',
            'principal_name',
            'idpuesto',
            'puesto',
            'grado_academico',
            'nombre',
            'apellido1',
            'apellido2',
        ]);
        $idproyecto = (int)$post['idproyecto'];
        $rules = $this->asesorInterno->getValidationRules();
        //Si no se cumplen las reglas se regresan los datos al formulario y la lista de errores
        if (!$this->validateData($post, $rules)) {
            return redirect()->to(base_url('usuario/residentes/asesor_interno'))->withInput()->with('error', $this->validator->listErrors());
        }
        $data = [
        'idpuesto'         => $post['idpuesto'],
        'principal_name'   => $post['principal_name'],
        'puesto'           => $post['puesto'],
        'grado_academico'  => $post['grado_academico'],
        'nombre'           => $post['nombre'],
        'apellido1'        => $post['apellido1'],
        'apellido2'        => $post['apellido2'],
        ];
        // Se insertan los datos del asesor y se actualiza el ID de asesor en el proyecto
        $estado = $this->asesorInterno->updateAsesorInternoByIdResidente($data, $idusuario, $idproyecto);
        if ($estado['success'] == false) {
            return redirect()->to(base_url('usuario/residentes/asesor_interno'))->withInput()->with('error', 'Error al agregar el asesor: ' . $estado['message']);
        }
        return redirect()->to(base_url('usuario/residentes/asesor_interno'))->withInput()->with('mensaje', $estado['message']);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($idusuario = null)
    {
        $post = $this->request->getPost([
            'idproyecto',
            'nombre_proyecto',
            'banco_proyecto',
            'fecha_periodo',
        ]);
        // Se separan las fechas del campo
        $periodo = $this->separarFechasDelPeriodo($post['fecha_periodo']);

        // Se asignan los valores a un arreglo
        $data = [
            'idproyecto'        => $post['idproyecto'],
            'idresidente'       => $idusuario,
            'nombre_proyecto'   => $post['nombre_proyecto'],
            'banco_proyecto'    => $post['banco_proyecto'],
            'fecha_inicio'      => $periodo['fecha_inicio'],
            'fecha_fin'         => $periodo['fecha_fin'],
        ];
        $rules = [
            'idproyecto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El ID del proyecto es obligatorio.',
                ],
            ],
            'idresidente' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El ID del residente es obligatorio.',
                ],
            ],
            'nombre_proyecto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El nombre del proyecto es obligatorio.',
                ],
            ],
            'fecha_inicio' => [
                'rules' => 'valid_date',
                'errors' => [
                    'valid_date' => 'La fecha de inicio es un campo requerido.',
                ],
            ],
            'fecha_fin' => [
                'rules' => 'valid_date',
                'errors' => [
                    'valid_date' => 'La fecha de finalizacion es un campo requerido.',
                ],
            ],
        ];

        // Se evalua los datos contruidos
        if (!$this->validateData($data, $rules)) {
            return redirect()->to(base_url('usuario/residentes/proyecto'))->withInput()->with('error', $this->validator->listErrors());
        }
        // Si los datos son validos se actualiza el proyecto
        $this->proyecto->update($post['idproyecto'], $data);
        // Se redirecciona a la vista de proyectos
        return redirect()->to(base_url('usuario/residentes/proyecto'))->withInput()->with('mensaje', 'Datos del proyecto actualizados con exito.');
    }

    public function separarFechasDelPeriodo(string $fecha)
    {
        // Separar las fechas del periodo
        $dates = explode(' - ', $fecha);
        // Asignar las fechas a una variable
        $fechaInicio = trim($dates[0]);
        $fechaFin = trim($dates[1]);
        // Se retornan las fechas en un arreglo
        return [
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
        ];
    }
    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
