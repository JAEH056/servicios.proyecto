<?php

namespace App\Controllers\Puestos;

use App\Controllers\BaseController;
use App\Utilidades\RecorrerOrganigrama;
class Puesto extends BaseController
{
    protected $recorrerOrganigrama;

    public function __construct()
    {
        // Instanciar la clase RecorrerOrganigrama
        $this->recorrerOrganigrama = new RecorrerOrganigrama();
    }

    // public function index(): string
    // {
    //     if (!session()->has('name')) {
    //         return redirect()->to('/oauth/login');
    //     }

    //     $userId = session()->get('idusuario');
    //     $user = session()->get('name');
    //     $token = session()->get('access_token'); // Línea para mandar los datos del Access token a la vista
    //     // $cargos = $this->recorrerOrganigrama->verOrganigrama();

    //     $data = [
    //         'user' => $user,
    //         'token' => $token,
    //         'idusuario' => $userId,
    //     //    'cargos'=>$cargos
           
    //     ];

    //     print_r($data);
    //     return view('');
    //     //return view('Empleado/empleado', $data);
    // }

    public function plantillaVista(){
        if (!session()->has('name')) {
                    return redirect()->to('/oauth/login');
                }
        
                $userId = session()->get('idusuario');
                $user = session()->get('name');
                $token = session()->get('access_token'); // Línea para mandar los datos del Access token a la vista
                // $cargos = $this->recorrerOrganigrama->verOrganigrama();
        
                $data = [
                    'user' => $user,
                    'token' => $token,
                    'idusuario' => $userId,
                //    'cargos'=>$cargos
                 'template'=>'Labs/layouts/principal_laboratorista'
                   
                ];
        
        

        return view('Empleado/empleado', $data);
    }

   
}
