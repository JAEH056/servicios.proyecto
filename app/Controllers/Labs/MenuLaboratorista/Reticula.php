<?php

namespace App\Controllers\Labs\MenuLaboratorista;

use App\Controllers\BaseController;
use App\Models\Labs\CarreraModel;
use App\Models\Labs\ReticuladModel;
use App\Models\Labs\ReticulaModel;

class Reticula extends BaseController {
    
    protected $model_reticula;
    protected $model_carrera;

    public  function __construct() {
        $this->model_reticula= model(ReticulaModel::class);
        $this->model_carrera=model(CarreraModel::class);
    }

    public function index($id_carera=null){
        $reticulaCarrera = $this->model_reticula->obtenerReticula($id_carera);
        $carrera=$this->model_carrera->obtenerCarrera();
        if (!$id_carera&& !empty($reticulaCarrera)) {
            return redirect()->to(base_url("reticula/" . $reticulaCarrera[0]['id']));
        }
        $data=[
            'carrera' => $carrera,
            'careraSeleccionada' => $id_carera,
        ];


        return view('Labs/layouts/reticula',$data);
    }

  
}
