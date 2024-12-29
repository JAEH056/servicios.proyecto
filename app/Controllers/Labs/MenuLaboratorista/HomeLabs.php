<?php

namespace App\Controllers\Labs\MenuLaboratorista;
use App\Controllers\BaseController;

class HomeLabs extends BaseController
{
    
    public function index()
    {
      //  Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        
        $data=[
            'user' => $user, 'token' => $token, 'idusuario' => $userId

        ];
        print_r($data);
        return view('Labs/layouts/horarios',$data); // Se agregan los datos a la vista
    }

}