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
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/datosProyecto', [
            'user' => $user,
            'token' => $token,
            'idusuario' => $this->userId,
            'datosEmpresa' => $datosEmpresa
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
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/datosAsesorInterno', [
            'user' => $user,
            'token' => $token,
            'idusuario' => $this->userId,
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

    public function guardarAsesorInterno()
    {
        $post = $this->request->getPost([
            'idpuesto',
            'cargo',
            'nombre',
            'apellido1',
            'apellido2',
            'principal_name',
        ]);
        $rules = $this->asesorInterno->getValidationRules();
        //Si no se cumplen las reglas se regresan los datos al formulario y la lista de errores
        if (!$this->validateData($post, $rules)) {
            return redirect()->to(base_url('usuario/residentes/asesor_interno'))->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'idpuesto',
            'cargo',
            'nombre',
            'apellido1',
            'apellido2',
            'principal_name',
        ];
        if ($this->residente->update($this->userId, $data) == false){
            return redirect()->to(base_url('usuario/residentes/asesor_interno'))->withInput()->with('error', 'Error al guardar los datos');
        }
        return redirect()->to(base_url('usuario/residentes/asesor_interno'))->withInput()->with('updatestatus', 'Datos guardados correctamente');
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
    public function update($id = null)
    {
        //
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
