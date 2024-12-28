<?php

namespace App\Controllers\Reposs\MenusDRPSS;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Reposs\ProgramaEducativoModel;
use App\Models\Reposs\ResidenteModel;

class Validacion extends BaseController
{
    protected $helpers = ['form'];
    protected $programasEducativo;
    protected $residentes;

    public function __construct()
    {
        $this->programasEducativo = new ProgramaEducativoModel();
        $this->residentes = new ResidenteModel();
    }

    public function index()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view(
            'Reposs/MenusDRPSS/documentosDRPSS',
            [
                'user'      => $user,
                'token'     => $token,
                'idusuario' => $userId,
            ]
        ); // Se agregan los datos a la vista
    }
}
