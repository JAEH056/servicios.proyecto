<?php

namespace App\Controllers\Reposs\MenusResidente;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Reposs\EmpresaModel;
use App\Models\Reposs\ProyectoModel;
use App\Models\Reposs\AsesorExternoModel;
use App\Models\Reposs\ResidenteModel;
use App\Models\Reposs\SectorModel;
use App\Models\Reposs\RamoModel;

class DatosProyecto extends ResourceController
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
    public function index()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

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
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
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
