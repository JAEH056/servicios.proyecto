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
use App\Models\Reposs\RequisitoModel;
use App\Models\Reposs\TipoArchivoModel;
use App\Models\Reposs\ValidacionModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Documentos extends ResourceController
{
    protected $preRequisitoModel;
    protected $requisitoModel;
    protected $validacionModel;
    protected $documentoModel;
    protected $residente;
    protected $ruta;
    protected $userId;
    protected $tipo;
    public function __construct()
    {
        $this->userId = session()->get('idusuario');
        $this->preRequisitoModel = new PreRequisitoModel();
        $this->requisitoModel = new RequisitoModel();
        $this->validacionModel = new ValidacionModel();
        $this->documentoModel = new DocumentoModel();
        $this->residente = new ResidenteModel();
        $this->tipo = new TipoArchivoModel();
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
            'kardex'                => $this->documentoModel->getDocumentByTipo("constancia_80%", $this->userId) ?? null,
            'constanciaSS'          => $this->documentoModel->getDocumentByTipo("constancia_servicio_social", $this->userId) ?? null,
            'constanciaAC'          => $this->documentoModel->getDocumentByTipo("constancia_actividades_complementarias", $this->userId) ?? null,
            'pagoReinscripcion'     => $this->documentoModel->getDocumentByTipo("pago_reinscripcion", $this->userId) ?? null,
            'vigenciaSeguro'        => $this->documentoModel->getDocumentByTipo("vigencia_seguro", $this->userId) ?? null,
            'solicitud_residencias' => $this->documentoModel->getDocumentByTipo("solicitud_residencias", $this->userId) ?? null,
            'carta_presentacion'    => $this->documentoModel->getDocumentByTipo("carta_presentacion", $this->userId) ?? null,
            'carta_aceptacion'      => $this->documentoModel->getDocumentByTipo("carta_aceptacion", $this->userId) ?? null,
            'anteproyecto'          => $this->documentoModel->getDocumentByTipo("anteproyecto", $this->userId) ?? null,
        ];
        // Se consulta el estado del documento (validacion-documento)
        $estadoDocumentos = $this->documentoModel->obtenerEstadoDocumento($this->userId);
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/documentos', [
            'user'                  => $user,
            'token'                 => $token,
            'idusuario'             => $this->userId,
            'errors'                => [],
            'kardex'                => $documento['kardex'],
            'constanciaSS'          => $documento['constanciaSS'],
            'constanciaAC'          => $documento['constanciaAC'],
            'pagoReinscripcion'     => $documento['pagoReinscripcion'],
            'vigenciaSeguro'        => $documento['vigenciaSeguro'],
            'solicitud_residencias' => $documento['solicitud_residencias'],
            'carta_presentacion'    => $documento['carta_presentacion'],
            'carta_aceptacion'      => $documento['carta_aceptacion'],
            'anteproyecto'          => $documento['anteproyecto'],
            'estadoDocumentos'      => $estadoDocumentos,
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

        // Arreglo de nombres (Tipo de archivo)
        $filenames = [
            1 => 'constancia_80%',
            2 => 'constancia_servicio_social',
            3 => 'constancia_actividades_complementarias',
            4 => 'pago_reinscripcion',
            5 => 'vigencia_seguro',
            6 => 'solicitud_residencias',
            7 => 'carta_presentacion',
            8 => 'carta_aceptacion',
            9 => 'anteproyecto',
            10 => 'reporte_parcial',
        ];

        if (!array_key_exists($id, $filenames)) {
            return redirect()->to(base_url('usuario/residentes/documentos'))->with('error', 'ID de documento no válido.');
        }
        // Valores que se utilizan en el upload dependiendo el id (tipo archivo)
        $filename = $filenames[$id];
        $errorname = "error{$filename}";
        $succesname = "success{$filename}";

        // Se obtienen los archivos
        $file = $this->request->getFile($filename);
        $validationRules = [
            $filename => $this->uploadRules($filename, $filename),
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->to(base_url('usuario/residentes/documentos'))->withInput()->with($errorname, 'Uno o más archivos no son válidos');
        }

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

        // Validar el id para guardar los datos en validacion
        if ($iddocumentoGuardado == null) {
            return redirect()->to(base_url('usuario/residentes/documentos'))->with('error', 'Error al guardar el documento');
        }

        $validarDoc = [
            'estado'        => 'Enviado',
            'observaciones' => 'Sin observaciones',
            'idpuesto'      => NULL,
            'iddocumento'   => $iddocumentoGuardado,
        ];

        if ($id <= 5) {
            $pre_requisito = [
                'idresidente' => $this->userId,
                'iddocumento' => $iddocumentoGuardado,
                'nombre_pre_requisito' => $filename,
            ];
            //Se inicia la transaccion
            try {
                $this->documentoModel->transException(true)->transStart();
                $this->validacionModel->save($validarDoc);
                $this->preRequisitoModel->save($pre_requisito);
                $this->documentoModel->transComplete();
            } catch (DatabaseException $e) {
                return redirect()->to(base_url('usuario/residentes/documentos'))->with('error', $e->getMessage());
            }
            // Se redirige a la vista de documentos con mensaje de éxito
            return redirect()->to(base_url('usuario/residentes/documentos'))->with($succesname, 'Documentos subidos correctamente');
        }
        if ($id > 5) {
            $requisito = [
                'idresidente' => $this->userId,
                'iddocumento' => $iddocumentoGuardado,
                'nombre_requisito' => $filename,
            ];
            //Se inicia la transaccion
            try {
                $this->documentoModel->transException(true)->transStart();
                $this->validacionModel->save($validarDoc);
                $this->requisitoModel->save($requisito);
                $this->documentoModel->transComplete();
            } catch (DatabaseException $e) {
                return redirect()->to(base_url('usuario/residentes/documentos'))->with('error', $e->getMessage());
            }
            // Se redirige a la vista de documentos con mensaje de éxito
            return redirect()->to(base_url('usuario/residentes/documentos'))->with($succesname, 'Documentos subidos correctamente');
        }
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
        // Obtener la configuración de ruta personalizada
        $nuevaRuta = $this->ruta->uploadPath;

        // Arreglo de nombres (Tipo de archivo)
        $documentos = [
            1 => [
                'tipo' => 'constancia_80%',
                'modelo' => $this->preRequisitoModel,
            ],
            2 => [
                'tipo' => 'constancia_servicio_social',
                'modelo' => $this->preRequisitoModel,
            ],
            3 => [
                'tipo' => 'constancia_actividades_complementarias',
                'modelo' => $this->preRequisitoModel,
            ],
            4 => [
                'tipo' => 'pago_reinscripcion',
                'modelo' => $this->preRequisitoModel,
            ],
            5 => [
                'tipo' => 'vigencia_seguro',
                'modelo' => $this->preRequisitoModel,
            ],
            6 => [
                'tipo' => 'solicitud_residencias',
                'modelo' => $this->requisitoModel,
            ],
            7 => [
                'tipo' => 'carta_presentacion',
                'modelo' => $this->requisitoModel,
            ],
            8 => [
                'tipo' => 'carta_aceptacion',
                'modelo' => $this->requisitoModel,
            ],
            9 => [
                'tipo' => 'anteproyecto',
                'modelo' => $this->requisitoModel,
            ],
        ];

        if (!array_key_exists($id, $documentos)) {
            return redirect()->to(base_url('usuario/residentes/documentos'))->with('error', 'ID de documento no válido.');
        }

        // Obtener el tipo de documento, modelo y mensajes basado en el valor de $id
        $tipoDocumento = $documentos[$id]['tipo'];
        $modelo = $documentos[$id]['modelo'];
        $errorname = "error{$tipoDocumento}";
        $succesname = "success{$tipoDocumento}";

        // Obtener el documento actual
        $documentoActual = $this->documentoModel->getDocumentByTipo($tipoDocumento, $this->userId);
        if (!$documentoActual) {
            return redirect()->to(base_url('usuario/residentes/documentos'))->with($errorname, 'No hay documento para eliminar');
        }

        // Eliminar el archivo del servidor
        $filePath = $nuevaRuta . '/' . $documentoActual['archivo'];
        if (!file_exists($filePath)) {
            return redirect()->to(base_url('usuario/residentes/documentos'))->with($errorname, 'El archivo no se encontró en el servidor');
        }

        // Se inicia la transacción
        try {
            $this->validacionModel->db->transException(true)->transStart();
            // Eliminar el registro de la base de datos
            $this->validacionModel->where('iddocumento', $documentoActual['iddocumento'])->delete();
            $modelo->where('iddocumento', $documentoActual['iddocumento'])->delete();
            $this->validacionModel->db->transComplete();
        } catch (DatabaseException $e) {
            return redirect()->to(base_url('usuario/residentes/documentos'))->with($errorname, 'Error al eliminar el documento de la base de datos'. $e->getMessage());
        }
        // Se elimina el archivo del servidor y base de datos
        $this->documentoModel->delete($documentoActual['iddocumento']);
        unlink($filePath);
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
            'errors' => [
                'uploaded'  => 'El archivo ' . $label . ' es obligatorio.',
                'ext_in'    => 'El archivo ' . $label . ' debe ser de tipo: {param}.',
                'max_size'  => 'El archivo ' . $label . ' no debe exceder los 2 MB.',
            ],
        ];
    }
}
