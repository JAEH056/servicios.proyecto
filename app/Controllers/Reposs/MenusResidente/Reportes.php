<?php

namespace App\Controllers\Reposs\MenusResidente;

use App\Controllers\BaseController;
use App\Models\Reposs\ResidenteModel;
use CodeIgniter\HTTP\RedirectResponse;
use App\Controllers\Reposs\RutaDocumentos;
use App\Models\Reposs\DocumentoModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\Models\Reposs\ValidacionModel;


class Reportes extends BaseController
{
    protected $documentoModel;
    protected $userId;
    protected $ruta;
    protected $validacionModel;
    protected $residenteModel;

    public function __construct()
    {
        $this->userId = session()->get('idusuario');
        $this->ruta = new RutaDocumentos();
        $this->documentoModel = new DocumentoModel();
        $this->residenteModel = new ResidenteModel();
        $this->validacionModel = new ValidacionModel();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse|string
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }
        // Obtener el archivo actual, si existe
        $numControl = $this->residenteModel->select('numero_control')->where('idresidente', $this->userId)->first();
        $documento = [
            'reporte_parcial' => $this->documentoModel->obtenerReporte('reporte_parcial') ?? null,
        ];
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/reporteParcial', [
            'user' => $user,
            'token' => $token,
            'idusuario' => $this->userId,
            'numControl' => $numControl,
            'reporteParcial' => $documento['reporte_parcial'],
        ]);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return RedirectResponse
     */
    public function upload($id = null, string $numControl ): RedirectResponse
    {
        // Obtener la configuración personalizada de la ruta
        $nuevaRuta = $this->ruta->uploadPath;
        // Arreglo de nombres (Tipo de archivo)
        $documentos = [
            10 => [
                'tipo' => 'reporte_parcial',
            ],
            11 => [
                'tipo' => 'reporte_parcial_2',
            ],
            12 => [
                'tipo' => 'reporte_final',
            ],
        ];
        if (!array_key_exists($id, $documentos)) {
            return redirect()->to(base_url('usuario/residentes/reportes'))->with('error', 'ID de documento no válido.');
        }
        // Valores que se utilizan en el upload dependiendo el id (tipo archivo)
        $tipoDocumento = $documentos[$id]['tipo'];
        $errorname = "error{$tipoDocumento}";
        $succesname = "success{$tipoDocumento}";

        // Se obtienen los archivos
        $file = $this->request->getFile($tipoDocumento);
        $validationRules = [
            $tipoDocumento => $this->uploadRules($tipoDocumento, $tipoDocumento),
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->to(base_url('usuario/residentes/reportes'))->withInput()->with($errorname, 'Uno o más archivos no son válidos' . $validationRules['errors']);
        }

        // Si el archivo se ha movido
        if (!$file->isValid() && $file->hasMoved()) {
            return redirect()->to(base_url('usuario/residentes/reportes'))->withInput()->with($errorname, 'Hubo un error al intentar guardar el documento');
        }
        // Se obtiene el nombre original
        $originalName = $file->getName();
        // Se quitan caracteres inseguros
        $safeName = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $originalName);
        // Se agrega un prefix personalizado (numero de control)
        $newName = $numControl . '_' . time() . '_' . $safeName;
        // Se guarda el archivo en el servidor
        $file->move($nuevaRuta, $newName);
        // Guardar el nombre del archivo en la base de datos
        $iddocumentoGuardado = $this->documentoModel->insert(['archivo' => $newName, 'idtipo' => $id]);

        // Validar el id para guardar los datos en validacion
        if ($iddocumentoGuardado === null) {
            return redirect()->to(base_url('usuario/residentes/reportes'))->with('error', 'Error al guardar el documento');
        }

        $validarDoc = [
            'estado'        => 'Enviado',
            'observaciones' => 'Sin observaciones',
            'idpuesto'      => NULL,
            'iddocumento'   => $iddocumentoGuardado,
        ];
        //Se inicia la transaccion
        try {
            $this->documentoModel->transException(true)->transStart();
            $this->validacionModel->save($validarDoc);
            $this->documentoModel->transComplete();
        } catch (DatabaseException $e) {
            return redirect()->to(base_url('usuario/residentes/reportes'))->with('error', $e->getMessage());
        }
        // Se redirige a la vista de documentos con mensaje de éxito
        return redirect()->to(base_url('usuario/residentes/reportes'))->with($succesname, 'Documentos subidos correctamente');
    }

    public function delete($id = null)
    {
        // Obtener la configuración de ruta personalizada
        $nuevaRuta = $this->ruta->uploadPath;

        // Arreglo de nombres (Tipo de archivo)
        $documentos = [
            10 => [
                'tipo' => 'reporte_parcial',
            ],
            11 => [
                'tipo' => 'reporte_parcial_2',
            ],
            12 => [
                'tipo' => 'reporte_final',
            ],
        ];

        if (!array_key_exists($id, $documentos)) {
            return redirect()->to(base_url('usuario/residentes/reportes'))->with('error', 'ID de documento no válido.');
        }

        // Obtener el tipo de documento, modelo y mensajes basado en el valor de $id
        $tipoDocumento = $documentos[$id]['tipo'];
        $errorname = "error{$tipoDocumento}";
        $succesname = "success{$tipoDocumento}";

        // Obtener el documento actual
        $documentoActual = $this->documentoModel->obtenerReporte($tipoDocumento);
        if (!$documentoActual) {
            return redirect()->to(base_url('usuario/residentes/reportes'))->with($errorname, 'No hay documento para eliminar');
        }

        // Eliminar el archivo del servidor
        $filePath = $nuevaRuta . '/' . $documentoActual['archivo'];
        if (!file_exists($filePath)) {
            return redirect()->to(base_url('usuario/residentes/reportes'))->with($errorname, 'El archivo no se encontró en el servidor');
        }

        // Se inicia la transacción
        try {
            $this->validacionModel->db->transException(true)->transStart();
            // Eliminar el registro de la base de datos
            $this->validacionModel->where('iddocumento', $documentoActual['iddocumento'])->delete();
            $this->validacionModel->db->transComplete();
        } catch (DatabaseException $e) {
            return redirect()->to(base_url('usuario/residentes/reportes'))->with($errorname, 'Error al eliminar el documento de la base de datos' . $e->getMessage());
        }
        // Se elimina el archivo del servidor y base de datos
        $this->documentoModel->delete($documentoActual['iddocumento']);
        if (!unlink($filePath)) {
            return redirect()->to(base_url('usuario/residentes/reportes'))->with($errorname, 'Error al eliminar el documento en el servidor!');
        }
        return redirect()->to(base_url('usuario/residentes/reportes'))->with($succesname, 'Documento eliminado correctamente');
    }

    /**
     * Summary of uploadRules
     * @param mixed $fieldName
     * @param mixed $label
     * @return array{errors: array{ext_in: string, max_size: string, uploaded: string, label: mixed, rules: string[]}}
     */
    private function uploadRules(string $fieldName, string $label): array
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
                'ext_in'    => 'El archivo ' . $label . ' debe ser de tipo: {pdf}.',
                'max_size'  => 'El archivo ' . $label . ' no debe exceder los 2 MB.',
            ],
        ];
    }
}
