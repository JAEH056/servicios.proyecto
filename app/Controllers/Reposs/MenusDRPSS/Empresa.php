<?php

namespace App\Controllers\Reposs\MenusDRPSS;

use App\Controllers\BaseController;
use App\Controllers\ResponseInterface;
use App\Models\Reposs\ResidenteModel;
//use CodeIgniter\HTTP\ResponseInterface;

class Empresa extends BaseController
{
    //Retorna los datos devuelta 'withInput()' al formulario
    protected $helpers = ['form'];

    public function index()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusDRPSS/nuevaEmpresa', ['user' => $user, 'token' => $token, 'idusuario' => $userId]); // Se agregan los datos a la vista
    }
    public function actualiza()
    {
        return view('residentes/actualiza');
    }
    public function new()
    {
        //return view('residentes/formulario');
    }
    public function guardar()
    {

        $rules = [
            'numero_control' => 'required',
            'nombre'    => 'required',
            'apellido1' => 'required',
            'apellido2' => 'required'
        ];
        //Si no se cumplen las reglas se regresan los datos al formulario y la lista de errores
        if (!$this->validate($rules)) {
            //return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
            return redirect()->to(base_url('residentes'))->withInput()->with('error', $this->validator->listErrors());
        }
        $post = $this->request->getPost([
            'idempresa',
            'nombre_empresa',
            'mision',
            'nombre_titular',
            'apellido1_titular',
            'apellido2_titular',
            'puesto_titular',
            'colonia',
            'ciudad',
            'codigo_postal',
            'telefono',
            'celular',
            'correo',
            'RFC',
            'idramo',
            'idsector',
            'idasesor_externo',
        ]);
        $residenteModel = new ResidenteModel();
        $residenteModel->insert([
            'nombre'    => trim($post['nombre']),
            'apellidoP' => trim($post['apellidoP']),
            'apellidoM' => trim($post['apellidoM']),
            'numControl' => trim($post['numControl']),
            'domicilio' => $post['domicilio'],
            'correo'    => $post['correo'],
            'ciudad'    => $post['ciudad'],
            'seguroSocial' => $post['seguroSocial'],
            'numeroSS'  => $post['numeroSS'],
            'telefono'  => $post['telefono'],
            'celular'   => $post['celular'],
            'idprogramaEducativo' => $post['idprogramaEducativo'],
        ]);

        //Si los datos se ingresaron correctamente regresa al formulario con un mensaje
        return redirect()->to(base_url('residentes'))->with('mensaje', 'Se actualizaron los datos');
    }
}