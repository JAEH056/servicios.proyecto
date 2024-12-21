<?php

namespace App\Controllers\Reposs\MenusResidente;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Files\File;
use App\Controllers\Reposs\RutaDocumentos;
use App\Models\Reposs\DocumentoModel;
use App\Models\Reposs\ResidenteModel;
use App\Config\Services;
use App\Models\Reposs\PreRequisitoModel;
use App\Models\Reposs\ValidacionModel;

class Documentos extends ResourceController
{
    protected $preRequisitoModel;
    protected $validacionModel;
    protected $documentoModel;
    protected $residente;
    protected $ruta;
    protected $userId;
    public function __construct()
    {
        $this->userId = session()->get('idusuario');
        $this->preRequisitoModel = new PreRequisitoModel();
        $this->validacionModel = new ValidacionModel();
        $this->documentoModel = new DocumentoModel();
        $this->residente = new ResidenteModel();
        $this->ruta = new RutaDocumentos();
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
        $documento = [
            'kardex'              => $this->documentoModel->getDocumentByTipo("kardex") ?? null,
            'constanciaSS'        => $this->documentoModel->getDocumentByTipo("constanciaSS") ?? null,
            'constanciaAC'        => $this->documentoModel->getDocumentByTipo("constanciaAC") ?? null,
            'pagoReinscripcion'   => $this->documentoModel->getDocumentByTipo("pagoReinscripcion") ?? null,
            'vigenciaSeguro'      => $this->documentoModel->getDocumentByTipo("vigenciaSeguro") ?? null,
        ];
        $pre_requsitos = [
            'kardex'              => $this->preRequisitoModel->getRequestById($this->userId, 1) ?? null,
            'constanciaSS'        => $this->preRequisitoModel->getRequestById($this->userId, 2) ?? null,
            'constanciaAC'        => $this->preRequisitoModel->getRequestById($this->userId, 3) ?? null,
            'pagoReinscripcion'   => $this->preRequisitoModel->getRequestById($this->userId, 4) ?? null,
            'vigenciaSeguro'      => $this->preRequisitoModel->getRequestById($this->userId, 5) ?? null,
        ];
        // Se consulta el estado del documento (validacion-documento)
        $estadoDocumentos = $this->documentoModel->obtenerEstadoDocumento($this->userId);

        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/documentos', [
            'user'               => $user,
            'token'              => $token,
            'idusuario'          => $this->userId,
            'errors'             => [],
            'kardex'             => $documento['kardex'],
            'constanciaSS'       => $documento['constanciaSS'],
            'constanciaAC'       => $documento['constanciaAC'],
            'pagoReinscripcion'  => $documento['pagoReinscripcion'],
            'vigenciaSeguro'     => $documento['vigenciaSeguro'],
            'estadoDocumentos'   => $estadoDocumentos,
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
    public function upload($id = null)
    {
        // Obtener la configuración personalizada de la ruta
        $nuevaRuta = $this->ruta->uploadPath;
        // Se inicializa filename
        $filename = null;
        switch ($id) {
            case 1:
                $filename = 'kardex';
                break;
            case 2:
                $filename = 'constanciaSS';
                break;
            case 3:
                $filename = 'constanciaAC';
                break;
            case 4:
                $filename = 'pagoReinscripcion';
                break;
            case 5:
                $filename = 'vigenciaSeguro';
                break;
            default:
                return redirect()->to(base_url('usuario/residentes/documentos'))->with('error', 'ID de documento no válido.');
        }
        // concatenar error/succes con su respectivo nombre
        $errorname = "error{$filename}";
        $succesname = "success{$filename}";
        $validationRules = [
            $filename => $this->uploadRules($filename, $filename),
        ];
        if (!$this->validate($validationRules)) {
            return redirect()->to(base_url('usuario/residentes/documentos'))->withInput()->with($errorname, 'Uno o más archivos no son válidos');
        }
        // Se obtienen los archivos
        $file = $this->request->getFile($filename);
        // Verificar si ya existe un documento
        // Si el archivo no se ha movido
        if ($file->isValid() && !$file->hasMoved()) {
            // Se obtiene el nombre original
            $originalName = $file->getName();
            // Se quitan caracteres inseguros
            $safeName = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $originalName);
            // Se agrega un prefix personalizado (numero de control)
            $newName = 'prefix_' . time() . '_' . $safeName;
            // Se guarda el archivo en el servidor       
            $file->move($nuevaRuta, $newName);
            // Guardar el nombre del archivo en la base de datos
            $iddocumentoGuardado = $this->documentoModel->insert(['archivo' => $newName, 'idtipo' => $id]);
        }
        if (empty($iddocumentoGuardado) == false) {
            $validarDoc = [
                'estado'        => 'Enviado',
                'observaciones' => 'Sin observaciones',
                'idpuesto'      => NULL,
                'iddocumento'   => $iddocumentoGuardado,
            ];
            $this->validacionModel->save($validarDoc);
            $pre_requisito = [
                'idresidente' => $this->userId,
                'iddocumento' => $iddocumentoGuardado,
                'nombre_pre_requisito' => $filename,
            ];
            $this->preRequisitoModel->save($pre_requisito);
        }
        // Se redirige a la vista de documentos con mensaje de éxito
        return redirect()->to(base_url('usuario/residentes/documentos'))->with($succesname, 'Documentos subidos correctamente');
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
    public function delete($id = null)
    {
        // Obtener la configuración personalizada de la ruta
        $nuevaRuta = $this->ruta->uploadPath;
        // Se inicializa filename
        $filename = null;
        switch ($id) {
            case 1:
                $filename = "kardex";
                break;
            case 2:
                $filename = "constanciaSS";
                break;
            case 3:
                $filename = "constanciaAC";
                break;
            case 4:
                $filename = "pagoReinscripcion";
                break;
            case 5:
                $filename = "vigenciaSeguro";
                break;
            default:
                return redirect()->to(base_url('usuario/residentes/documentos'))->with('error', 'ID de documento no válido.');
        }
        // concatenar error/succes con su respectivo nombre
        $errorname = "error{$filename}";
        $succesname = "success{$filename}";
        // Obtener el documento actual
        $documentoActual = $this->documentoModel->getDocumentByTipo($filename);
        if (!$documentoActual) {
            return redirect()->to(base_url('usuario/residentes/documentos'))->with($errorname, 'No hay documento para eliminar');
        }
        // Eliminar el archivo del servidor
        //unlink($nuevaRuta . '/' . $documentoActual['archivo']);
        // Eliminar el registro de la base de datos
        if (
            $this->validacionModel->delete('iddocumento', $documentoActual['iddocumento']) == true &&
            $this->preRequisitoModel->delete('idresidente', $this->userId) == true
        ) {
            $this->documentoModel->delete($documentoActual['iddocumento']);
        }

        return redirect()->to(base_url('usuario/residentes/documentos'))->with($succesname, 'Documento eliminado correctamente');
    }
    private function uploadRules($fieldName, $label)
    {
        return [
            'label' => $label,
            'rules' => [
                "uploaded[$fieldName]",
                "max_size[$fieldName,2048]", // Allow up to 2 MB
                "ext_in[$fieldName,pdf,doc,docx]", // Allow PDF, DOC, and DOCX files
            ],
        ];
    }
}
