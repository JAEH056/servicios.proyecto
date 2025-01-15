<?php

namespace App\Controllers\Reposs\MenusResidente;

use App\Controllers\BaseController;
use App\Controllers\ResponseInterface;
use App\Models\Reposs\ResidenteModel;
use App\Models\Reposs\ProgramaEducativoModel;

class DatosResidente extends BaseController
{
    //Retorna los datos devuelta 'withInput()' al formulario
    protected $helpers = ['form'];
    protected $residente;
    protected $programaE;
    protected $userId;

    public function __construct()
    {
        $this->residente = new ResidenteModel();
        $this->programaE = new ProgramaEducativoModel();
        $this->userId = session()->get('idusuario');
    }

    public function index()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        //$userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');
        $programaEducativo = $this->programaE->findAll();
        $datosResidente = $this->residente->findByCorreo($this->userId) ;//$this->residente->where('principal_name', $user['userPrincipalName'])->first();
        // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/datosResidente', [
            'user'      => $user,
            'token'     => $token,
            'idusuario' => $this->userId,
            'programa'  => $programaEducativo,
            'datosResidente' => $datosResidente,
        ]); // Se agregan los datos a la vista
    }

    /**
     * Se actualizan los datos del residente (solo podra modificar ciertos campos)
    */
    public function update()
    {
        $post = $this->request->getPost([
            'idprograma_educativo',
            'principal_name',
            'numero_control',
            'nombre',
            'apellido1',
            'apellido2',
            'domicilio',
            'ciudad',
            'seguro_social',
            'numero_ss',
            'telefono',
            'celular'
        ]);
        $rules = $this->residente->getValidationRules();
        //Si no se cumplen las reglas se regresan los datos al formulario y la lista de errores
        if (!$this->validateData($post, $rules)) {
            return redirect()->to(base_url('usuario/residentes/datos'))->withInput()->with('error', $this->validator->listErrors());
        }
        $data = [
            'idprograma_educativo'  => trim($post['idprograma_educativo']),
            'principal_name'        => trim($post['principal_name']),
            'numero_control'        => trim($post['numero_control']),
            'nombre'                => trim($post['nombre']),
            'apellido1'             => $post['apellido1'],
            'apellido2'             => $post['apellido2'],
            'domicilio'             => $post['domicilio'],
            'ciudad'                => $post['ciudad'],
            'seguro_social'         => $post['seguro_social'],
            'numero_ss'             => $post['numero_ss'],
            'telefono'              => $post['telefono'],
            'celular'               => $post['celular'],
        ];
        if ($this->residente->update($this->userId, $data) == false){
            return redirect()->to(base_url('usuario/residentes/datos'))->withInput()->with('error', 'Error al actualizar los datos');
        }
        return redirect()->to(base_url('usuario/residentes/datos'))->withInput()->with('updatestatus', 'Datos Actualizados Correctamente');
    }

    public function new()
    {
        //return view('residentes/formulario');
    }

}
