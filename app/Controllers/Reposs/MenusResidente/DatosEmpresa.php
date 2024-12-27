<?php

namespace App\Controllers\Reposs\MenusResidente;

use App\Models\Reposs\AsesorExternoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Reposs\ResidenteModel;
use App\Models\Reposs\EmpresaModel;
use App\Models\Reposs\ProyectoModel;
use App\Models\Reposs\SectorModel;
use App\Models\Reposs\RamoModel;

class DatosEmpresa extends ResourceController
{
    protected $asesorExterno;
    protected $residente;
    protected $proyecto;
    protected $empresa;
    protected $userId;
    protected $sector;
    protected $ramo;

    public function __construct()
    {
        $this->asesorExterno = new AsesorExternoModel();
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
    public function index(): ResponseInterface|string
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }
        $datosEmpresa = $this->empresa->getEmpresaByUserId($this->userId);
        $asesorExterno = $this->empresa->getAsesorFromEmpresa($this->userId);
        $opcionSector = $this->sector->findAll();
        $opcionRamo = $this->ramo->findAll();
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/datosEmpresa', [
            'user' => $user,
            'token' => $token,
            'idusuario' => $this->userId,
            'datosEmpresa' => $datosEmpresa,
            'opcionSector' => $opcionSector,
            'opcionRamo' => $opcionRamo,
            'asesorExterno' => $asesorExterno,
        ]); // Se agregan los datos a la vista
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null): void
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new(): void
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
        $post = $this->request->getPost([
            'nombre_empresa',
            'mision',
            'puesto_titular',
            'grado_titular',
            'nombre_titular',
            'apellido1_titular',
            'apellido2_titular',
            'colonia',
            'ciudad',
            'codigo_postal',
            'telefono',
            'celular',
            'correo',
            'RFC',
            'idramo',
            'idsector',
            'idasesor_externo',
        ]);
        //Si no se cumplen las reglas se regresan los datos al formulario y la lista de errores
        if (!$this->empresa->getValidationRules($post)) {
            return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('error', $this->validator->listErrors());
        }
        if (!$idempresa = $this->empresa->insert([
            'nombre_empresa'        => $post['nombre_empresa'],
            'mision'                => $post['mision'],
            'puesto_titular'        => $post['puesto_titular'],
            'grado_titular'         => $post['grado_titular'],
            'nombre_titular'        => $post['nombre_titular'],
            'apellido1_titular'     => $post['apellido1_titular'],
            'apellido2_titular'     => $post['apellido2_titular'],
            'colonia'               => $post['colonia'],
            'ciudad'                => $post['ciudad'],
            'codigo_postal'         => $post['codigo_postal'],
            'telefono'              => $post['telefono'],
            'celular'               => $post['celular'],
            'correo'                => $post['correo'],
            'RFC'                   => $post['RFC'],
            'idramo'                => $post['idramo'],
            'idsector'              => $post['idsector'],
            'idasesor_externo'      => $post['idasesor_externo'] ?? null,
        ])) {
            return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('error', 'Error al agregar la empresa.');
        }
        $datosProyecto = [
            'nombre_proyecto'   => null,
            'banco_proyecto'    => null,
            'idresidente'       => $this->userId,
            'idempresa'         => $idempresa,
            'idasesor_interno'  => $post['idasesor_externo'],
            'fecha_inicio'      => null,
            'fecha_fin'         => null,
        ];
        if ($this->proyecto->save($datosProyecto) == false) {
            return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('error', 'Error al agregar la empresa (proyecto).');
        }
        return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('mensaje', 'Empresa creada con exito.');
    }

    public function createAsesor()
    {
        $post = $this->request->getPost([
            'puesto',
            'grado',
            'nombre',
            'apellido1',
            'apellido2',
            'correo',
            'telefono'
        ]);
        //Si no se cumplen las reglas se regresan los datos al formulario y la lista de errores
        if (!$this->asesorExterno->getValidationRules($post)) {
            return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('error', $this->validator->listErrors());
        }

        $response = $this->asesorExterno->updateAsesorExternoByIdResidente($post, $this->userId);

        if (!$response['success']) {
            // Handle the error
            return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('error', $response['message']);
        } else {
            // Success
            echo $response['message'];
            return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('mensaje', $response['message']);
        }
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null): void
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
    public function update($id = null): void
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
    public function delete($id = null): void
    {
        //
    }
}
