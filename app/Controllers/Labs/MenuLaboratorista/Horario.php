<?php

namespace App\Controllers\Labs\MenuLaboratorista;

use App\Controllers\BaseController;
use App\Models\Labs\LaboratorioModel;

class Horario extends BaseController
{

    protected $model_laboratorio;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->model_laboratorio = model(LaboratorioModel::class);

    }
    public function index()
    {
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }
        
        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token');
      
        return view('Labs/layouts/horario',[
                'user'=>$user,'id_usuario'=>$userId,'token'=>$token]);
   
    }
    public function nuevo(){
        $laboratorio= $this->model_laboratorio->obtenerLaboratorios();
        return view('');


    }

    public function crear(){
        
    }

       
}
