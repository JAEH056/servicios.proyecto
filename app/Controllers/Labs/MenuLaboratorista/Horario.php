<?php

namespace App\Controllers\Labs\MenuLaboratorista;

use App\Controllers\BaseController;
use App\Models\Labs\LaboratorioModel;

class Horario extends BaseController
{
    protected $model_laboratorio;

    public function __construct()
    {
        $this->model_laboratorio = model(LaboratorioModel::class);
    }
    public function index()
    { $laboratorios = $this->model_laboratorio->obtenerLaboratorios();

        $data = [
            'laboratorios' => $laboratorios,
        ];

        print_r($data);
        return view('Labs/layouts/asignar_laboratorio', $data);
    }

       
}
