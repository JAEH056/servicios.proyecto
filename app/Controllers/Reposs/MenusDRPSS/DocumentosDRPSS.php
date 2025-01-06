<?php

namespace App\Controllers\Reposs\MenusDRPSS;

use App\Controllers\BaseController;
use App\Models\Reposs\DocumentoModel;
use App\Models\Reposs\ProgramaEducativoModel;
use App\Models\Reposs\ResidenteModel;
use App\Controllers\Reposs\RutaDocumentos;
use App\Models\PuestoEmpleado\PuestoEmpleadoModel;
use App\Models\Reposs\ValidacionModel;

class DocumentosDRPSS extends BaseController
{
    protected $helpers = ['form'];
    protected $programasEducativo;
    protected $residentes;
    protected $documento;
    protected $validacion;
    protected $puesto;
    protected $ruta;
    protected $userId;

    public function __construct()
    {
        $this->programasEducativo   = new ProgramaEducativoModel();
        $this->residentes           = new ResidenteModel();
        $this->documento            = new DocumentoModel();
        $this->validacion           = new ValidacionModel();
        $this->puesto               = new PuestoEmpleadoModel();
        $this->ruta                 = new RutaDocumentos();
        $this->userId               = session()->get('idusuario');
    }

    public function index()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }
        $user = session()->get('name');
        $token = session()->get('access_token');
        return view(
            'Reposs/MenusDRPSS/perfilResidenteDRPSS',
            [
                'user'      => $user,
                'token'     => $token,
                'idusuario' => $this->userId,
            ]
        );
    }

    /*
    *   Carga la vista del perfil de residente en drpss
    */
    public function perfil($numeroControl)
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $datosResidente = $this->residentes->residentesInfoListByNumeroControl($numeroControl);
        $user = session()->get('name');
        $token = session()->get('access_token');
        return view(
            'Reposs/MenusDRPSS/perfilResidenteDRPSS',
            [
                'user'      => $user,
                'token'     => $token,
                'idusuario' => $this->userId,
                'datosResidente' => $datosResidente,
            ]
        ); // Se agregan los datos a la vista
    }

    /*
    *   Carga la vista de los documetos de residente en drpss
    */
    public function documentos($numeroControl)
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $puestoId = $this->puesto->puestoUsuario($this->userId);
        $rutaDocumentos = $this->ruta->uploadPath;
        $datosResidente = $this->residentes->residentesInfoListByNumeroControl($numeroControl);
        $documentos = $this->documento->obtenerDocumentosParaValidar($numeroControl);
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view(
            'Reposs/MenusDRPSS/documentosResidenteDRPSS',
            [
                'user'      => $user,
                'token'     => $token,
                'idusuario' => $this->userId,
                'puestoId' =>  $puestoId,
                'documentos' => $documentos,
                'datosResidente' => $datosResidente,
                'rutaDocumentos' => $rutaDocumentos,
            ]
        ); // Se agregan los datos a la vista
    }

    /*
    *   Carga la vista del documento (en el modal) de residente en drpss
    */
    public function vistaArchivo($filename)
    {
        // Ruta de acceso a los documentos guardados
        $filePath = $this->ruta->uploadPath . $filename;
        // Validar si el archivo existe
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404, 'File not found');
        }
        // Se carga la vista para mostrar el documento (en el modal)
        return $this->response->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . basename($filePath) . '"')
            ->setHeader('Content-Length', filesize($filePath))
            ->setBody(file_get_contents($filePath));
    }

    /*
    *   Carga la vista del documento (en el modal) para su posterior descarga.
    */
    public function descargarArchivo($nombreArchivo)
    {
        $rutaArchivo = $this->ruta->uploadPath . $nombreArchivo;
        // Verificar si el archivo existe
        if (!file_exists($rutaArchivo)) {
            return $this->response->setStatusCode(404, 'Archivo no encontrado');
        }
        // Iniciar la descarga del archivo
        //return $this->response->download($rutaArchivo, null)->inline();
        return $this->response->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . basename($rutaArchivo) . '"')
            ->setHeader('Content-Length', filesize($rutaArchivo))
            ->setBody(file_get_contents($rutaArchivo));
    }

    /*
    *   Funcion para validar los documentos del residente
    *   Nota: requiere el numero de control para retornar a la vista.
    */
    public function validarDocumentos($numeroControl)
    {
        $post = $this->request->getPost();
        $rules = $this->validacion->getValidationRules();
        //Se validan los datos del post con las reglas del modelo (validacion)
        if (!$this->validateData($post, $rules)) {
            return redirect()->to(base_url('usuario/drpss/documentos/' . $numeroControl))->with('error', 'Error al validar el formulario');
        }
        $data = [
            'idvalidacion'  => $post['idvalidacion'],
            'estado'        => $post['estado'],
            'observaciones' => $post['observaciones'],
            'idpuesto'      => $post['idpuesto'],
            'iddocumento'   => $post['iddocumento'],
        ];
        try {
            if ($this->validacion->save($data)) {
                return redirect()->to(base_url('usuario/drpss/documentos/'. $numeroControl))->with('message', 'Estado del documento actualizado con éxito');
            } else {
                return redirect()->to(base_url('usuario/drpss/documentos/'. $numeroControl))->with('error', 'Error al actualizar el documento');
            }
        } catch (\Exception $e) {
            return redirect()->to(base_url('usuario/drpss/documentos/'. $numeroControl))->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
}
