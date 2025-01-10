<?php

namespace App\Controllers\Reposs\MenusDRPSS;

use App\Controllers\BaseController;
use App\Controllers\ResponseInterface;
use App\Models\Reposs\ProgramaEducativoModel;
use App\Models\Reposs\ResidenteModel;
use CodeIgniter\HTTP\RedirectResponse;

//use CodeIgniter\HTTP\ResponseInterface;

class Residente extends BaseController
{
    //Retorna los datos devuelta 'withInput()' al formulario
    protected $helpers = ['form'];
    protected $programasEducativo;
    protected $residentes;
    protected $userId;

    public function __construct()
    {
        $this->programasEducativo = new ProgramaEducativoModel();
        $this->residentes = new ResidenteModel();
        $this->userId = session()->get('idusuario');
    }

    public function index()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }
        $programasEducativo = $this->programasEducativo->getProgramaEducativo();
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view(
            'Reposs/MenusDRPSS/nuevoResidente',
            [
                'user'      => $user,
                'token'     => $token,
                'idusuario' => $this->userId,
                'programa'  => $programasEducativo
            ]
        ); // Se agregan los datos a la vista
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
    public function listaResidentes()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $listaResidentes = $this->residentes->residentesInfoList();
        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusDRPSS/listaResidentes', [
            'user' => $user, 
            'token' => $token, 
            'idusuario' => $userId, 
            'listaResidentes' => $listaResidentes]); // Se agregan los datos a la vista
    }
    public function new()
    {
        //return view('residentes/formulario');
    }

    /*
    *   Funcion para guardar los datos de un nuevo estudiante (candidato).
    */
    public function guardar(): RedirectResponse
    {
        helper('form');
        // Se obtienen los datos del formulario
        $data = $this->request->getPost([
            'idprograma_educativo',
            'numero_control',
            'nombre',
            'apellido1',
            'apellido2',
        ]);
        //Si no se cumplen las reglas, se regresan los datos al formulario y la lista de errores
        if (! $this->validateData($data, [
            'idprograma_educativo' => 'required',
            'numero_control' => 'required',
            'nombre'         => 'required',
            'apellido1'      => 'required',
            'apellido2'      => 'max_length[255]',
        ])) {
            return redirect()->to(base_url('usuario/drpss/nuevo'))->withInput()->with('error', $this->validator->listErrors());
        }
        // Gets the validated data.
        $post = $this->validator->getValidated();

        // Verificar si existe el residente
        if ($this->residentes->esPrimerIngreso(trim($post['numero_control'])) == false) {
            return redirect()->to(base_url('usuario/drpss/nuevo'))->with('error', 'El usuario ya existe');
        }
        // Concatenar el correo con el dominio
        $principal_name = trim($post['numero_control']) . '@alum.huatusco.tecnm.mx';

        $this->residentes->insert([
            'idprograma_educativo'  => $post['idprograma_educativo'],
            'principal_name'        => $principal_name,
            'numero_control'        => trim($post['numero_control']),
            'nombre'                => trim($post['nombre']),
            'apellido1'             => trim($post['apellido1']),
            'apellido2'             => trim($post['apellido2']),
        ]);

        //Si los datos se ingresaron correctamente regresa al formulario con un mensaje
        return redirect()->to(base_url('usuario/drpss/nuevo'))->with('message', 'Se actualizaron los datos' . $principal_name);
    }
}
