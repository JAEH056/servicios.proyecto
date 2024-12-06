<?php

namespace App\Controllers\Reposs\MenusResidente;

use App\Controllers\BaseController;
use App\Controllers\ResponseInterface;
use App\Models\Reposs\ResidenteModel;
//use CodeIgniter\HTTP\ResponseInterface;

class ActualizaDatos extends BaseController
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
        return view('Reposs/MenusResidente/actualizarDatos', ['user' => $user, 'token' => $token, 'idusuario' => $userId]); // Se agregan los datos a la vista
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
            'nombre'    => 'required',
            'apellidoP' => 'required',
            'numControl' => 'required|is_unique[residente.numControl]',
            'domicilio' => 'required',
            'correo'    => 'required|valid_email|is_unique[residente.correo]',
            'ciudad'    => 'required',
            'seguroSocial' => 'required',
            'numeroSS'  => 'required|is_unique[residente.numeroSS]',
            'celular'   => 'required|min_length[10]'
        ];
        //Si no se cumplen las reglas se regresan los datos al formulario y la lista de errores
        if (!$this->validate($rules)) {
            //return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
            return redirect()->to(base_url('residentes'))->withInput()->with('error', $this->validator->listErrors());
        }
        $post = $this->request->getPost([
            'nombre',
            'apellidoP',
            'apellidoM',
            'numControl',
            'domicilio',
            'correo',
            'ciudad',
            'seguroSocial',
            'numeroSS',
            'telefono',
            'celular',
            'idprogramaEducativo'
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
