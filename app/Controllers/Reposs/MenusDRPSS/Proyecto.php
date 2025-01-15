<?php

namespace App\Controllers\Reposs\MenusDRPSS;

use App\Controllers\BaseController;
use App\Models\Reposs\ProyectoModel;
use App\Models\Reposs\ResidenteModel;
use CodeIgniter\HTTP\ResponseInterface;

class Proyecto extends BaseController
{
    protected $proyectoModel;
    protected $residente;
    protected $userId;
    public function __construct(){
        $this->proyectoModel = new ProyectoModel();
        $this->residente = new ResidenteModel();
        $this->userId = session()->get('idusuario');
    }
    public function index()
    {
        //
    }

    /*
    *   Carga la vista del proyecto del residente en drpss
    */
    public function infoProyecto($numeroControl)
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $datosResidente = $this->residente->residentesInfoListByNumeroControl($numeroControl);
        $proyectos = $this->proyectoModel->getProyectoByNumeroControl($numeroControl);
        $user = session()->get('name');
        $token = session()->get('access_token');
        return view(
            'Reposs/MenusDRPSS/proyectoResidenteDRPSS',
            [
                'user'      => $user,
                'token'     => $token,
                'idusuario' => $this->userId,
                'datosResidente' => $datosResidente,
                'proyectos' => $proyectos,
            ]
        ); // Se agregan los datos a la vista
    }
    /**
     *  Lista de proyectos creados y detalles
     */
    public function getListaProyectos()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $listaProyectos = $this->proyectoModel->getListaProyectos();
        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusDRPSS/listaProyectos', [
            'user'      => $user,
            'token'     => $token,
            'idusuario' => $userId,
            'listaProyectos' => $listaProyectos,
        ]);
    }
}
