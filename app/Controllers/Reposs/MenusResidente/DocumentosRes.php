<?php

namespace App\Controllers\Reposs\MenusResidente;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Reposs\DocumentoModel;
use App\Models\Reposs\ResidenteModel;
use App\Controllers\Reposs\RutaDocumentos;

class DocumentosRes extends ResourceController
{
    protected $documentoModel;
    protected $residente;
    protected $ruta;

    public function __construct()
    {
        $this->documentoModel = new DocumentoModel();
        $this->residente = new ResidenteModel();
        $this->ruta = new RutaDocumentos();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index(): string
    {
        // Obtener el archivo actual, si existe
        $currentDocument = $this->documentoModel->getCurrentDocument();
        $kardex = $this->documentoModel->getDocumentByTipo('kardex');
        $constanciaSS = $this->documentoModel->getDocumentByTipo('constanciaSS ');
        $constanciaAC = $this->documentoModel->getDocumentByTipo('constanciaAC');
        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');
        // Cargar vista y pasar la información
        return view('usuario/residentes/documento', [
            'user' => $user,
            'token' => $token,
            'idusuario' => $userId,
            'currentDocument' => $currentDocument,
            'kardex' => $kardex,
            'constanciaSS' => $constanciaSS,
            'constanciaAC' => $constanciaAC,
        ]);
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

    public function upload2($id = null)
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
            $this->documentoModel->insert(['archivo' => $newName, 'idtipo' => $id]);
        }
        // Se redirige a la vista de documentos con mensaje de éxito
        return redirect()->to(base_url('usuario/residentes/documentos'))->with($succesname, 'Documentos subidos correctamente');
    }

    public function upload()
    {
        // Obtener la configuración personalizada de la ruta
        $nuevaRuta = $this->ruta->uploadPath;
        // Trabajando con multiples archivos
        if ($documents = $this->request->getFiles()) {
            foreach ($documents['document'] as $doc) {
                if ($doc->isValid() && ! $doc->hasMoved()) {
                    // Se obtiene el nombre original /// $newName = $file->getRandomName();
                    $originalName = $doc->getName();
                    //Se quitan caracteres inseguros
                    $safeName = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $originalName);
                    // Se agrega un prefix personalizado (numero de control)
                    $newName = 'prefix_' . time() . '_' . $safeName;
                    $doc->move($nuevaRuta, $newName);
                    // Guardar el nombre del archivo en la base de datos
                    $this->documentoModel->insert(['archivo' => $newName, 'idtipo' => 1]);
                }
            }
            // Se redirige a la vista de documentos con mensaje de exito
            return redirect()->to(base_url('usuario/residentes/documentos'))->with('success', 'Documento subido correctamente');
        }
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
        unlink($nuevaRuta . '/' . $documentoActual['archivo']);
        // Eliminar el registro de la base de datos
        $this->documentoModel->delete($documentoActual['iddocumento']);

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
