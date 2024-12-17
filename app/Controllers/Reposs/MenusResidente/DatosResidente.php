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

    public function index()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }
        $programasEducativo = new ProgramaEducativoModel();
        $programasEducativo = $programasEducativo->findAll();

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/datosResidente', [
            'user'      => $user,
            'token'     => $token,
            'idusuario' => $userId,
            'programa'  => $programasEducativo
        ]); // Se agregan los datos a la vista
    }
    public function actualiza()
    {
        return view('');
    }
    public function new()
    {
        //return view('residentes/formulario');
    }
    public function guardar()
    {
        $rules = [
            'nombre'            => 'required|max_length[255]',
            'apellido1'         => 'required|max_length[255]',
            'numero_control'    => 'required|is_unique[residente.numero_control]',
            'domicilio'         => 'max_length[255]',
            'ciudad'            => 'max_length[255]',
            'seguro_social'     => 'required',
            'numero_ss'         => 'required|is_unique[residente.numero_ss]',
            'celular'           => 'min_length[10]'
        ];
        //Si no se cumplen las reglas se regresan los datos al formulario y la lista de errores
        if (!$this->validate($rules)) {
            return redirect()->to(base_url('usuario/residentes/datos'))->withInput()->with('error', $this->validator->listErrors());
        }
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
        $residenteModel = new ResidenteModel();
        $residenteModel->insert([
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
        ]);

        //Si los datos se ingresaron correctamente regresa al formulario con un mensaje
        return redirect()->to(base_url('usuario/residentes/datos'))->with('mensaje', 'Se actualizaron los datos');
    }
}
