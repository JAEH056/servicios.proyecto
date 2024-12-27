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
    public function index()
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
        $post = $this->request->getPost([
            'idasesor_externo',
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
        if ($this->asesorExterno->updateAsesorExternoByIdResidente($post, $this->userId) == false) {
            return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('error', 'Error al agregar el asesor.');
        }
        return redirect()->to(base_url('usuario/residentes/empresa'))->withInput()->with('mensaje', 'Asesor agregado con exito.');
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
