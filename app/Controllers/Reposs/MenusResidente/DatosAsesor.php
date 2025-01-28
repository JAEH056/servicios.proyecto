<?php

namespace App\Controllers\Reposs\MenusResidente;

use App\Models\Reposs\AsesorExternoModel;
use App\Models\Reposs\ProyectoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class DatosAsesor extends ResourceController
{
    protected $asesorExterno;
    protected $proyecto;
    protected $userId;
    public function __construct()
    {
        $this->asesorExterno = new AsesorExternoModel();
        $this->proyecto = new ProyectoModel();
        $this->userId = session()->get('idusuario');
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index(): void
    {
        //
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
            'idasesor_externo',
            'puesto',
            'grado',
            'nombre',
            'apellido1',
            'apellido2',
            'correo',
            'telefono',
            'idempresa',
        ]);
        $idEmpresa = $post['idempresa'];
        //Si no se cumplen las reglas se regresan los datos al formulario y la lista de errores
        $rules = $this->asesorExterno->getValidationRules();
        if (!$this->validateData($post, $rules)) {
            return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('error', $this->validator->listErrors());
        }
        $estado = $this->asesorExterno->updateAsesorExternoByIdResidente($post, $this->userId, $idEmpresa);
        if ($estado['success'] == false) {
            return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('error', 'Error al agregar el asesor: ' . $estado['message']);
        }
        return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('mensaje', $estado['message']);
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
