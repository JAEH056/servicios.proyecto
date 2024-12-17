<?php

namespace App\Controllers\Reposs\MenusResidente;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Files\File;
use App\Models\Reposs\DocumentoModel;
use App\Models\Reposs\ResidenteModel;
use App\Config\Services;

class Documentos extends ResourceController
{
    protected $documentoModel;
    protected $residente;
    public function __construct()
    {
        $this->documentoModel = new DocumentoModel();
        $this->residente = new ResidenteModel();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index(): ResponseInterface|string
    {
        $helpers = ['form'];
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }
        // Obtener el archivo actual, si existe
        $kardex             = $this->documentoModel->getDocumentByTipo("kardex");
        $constanciaSS       = $this->documentoModel->getDocumentByTipo("constanciaSS");
        $constanciaAC       = $this->documentoModel->getDocumentByTipo("constanciaAC");
        $pagoReinscripcion  = $this->documentoModel->getDocumentByTipo("pagoReinscripcion");
        $vigenciaSeguro     = $this->documentoModel->getDocumentByTipo("vigenciaSeguro");
        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/documentos', [
            'user'              => $user,
            'token'             => $token,
            'idusuario'         => $userId,
            'errors'            => [],
            'kardex'            => $kardex,
            'constanciaSS'      => $constanciaSS,
            'constanciaAC'      => $constanciaAC,
            'pagoReinscripcion' => $pagoReinscripcion,
            'vigenciaSeguro'    => $vigenciaSeguro,
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
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function upload(): ResponseInterface|string
    {
        // Se obtienen los datos para regresar a la vista
        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');
        //Reglas de validacion de documentos
        $validationRule = [
            'userfile' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[userfile]',
                    'is_image[userfile]',
                    'mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                    'max_size[userfile,1000]',
                    'max_dims[userfile,1920,1080]',
                ],
            ],
        ];
        // Se validan las regalas, si hay error se carga la vista
        if (! $this->validateData([], $validationRule)) {
            $fileData = ['errors' => $this->validator->getErrors()];
            return view('Reposs/MenusResidente/documentos', [
                'user' => $user,
                'token' => $token,
                'idusuario' => $userId,
                'errors' => $fileData['errors'],
            ]); // Se agregan los datos a la vista
        }
        // Se obtiene el archivo
        $documento = $this->request->getFile('userfile');
        // Si no se ha movido se guarda el archivo
        if (! $documento->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $documento->store(); /// Se guarda el archivo
            $fileData = ['uploaded_fileinfo' => new File($filepath)]; /// Se obtiene la informacion del archivo 
            return view('Reposs/MenusResidente/documentos', [
                'user' => $user,
                'token' => $token,
                'idusuario' => $userId,
                'errors' => [],
                'uploaded_fileinfo' => $fileData['uploaded_fileinfo'],
            ]); // Se agregan los datos a la vista
        }
        // Si el archivo no se encuentra en el temporal se regresa mensaje de error
        $fileData = ['errors' => 'The file has already been moved.'];
        return view('Reposs/MenusResidente/documentos', [
            'user' => $user,
            'token' => $token,
            'idusuario' => $userId,
            'errors' => $fileData['errors'],
        ]); // Se agregan los datos a la vista
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
    public function create(): void
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
