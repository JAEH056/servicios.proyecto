<?php

namespace App\Controllers\Reposs\MenusResidente;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class InicioResidente extends BaseController
{
    public function index()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/inicioResidente', ['user' => $user, 'token' => $token, 'idusuario'=> $userId]); // Se agregan los datos a la vista
    }
}
