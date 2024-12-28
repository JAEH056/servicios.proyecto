<?php

namespace App\Controllers\Labs\MenuLaboratorista;

use App\Controllers\BaseController;
use App\Models\Labs\AsignarLaboratorioModel;
use App\Models\Labs\DiasInhabilesModel;
use App\Models\Labs\TipoDiaInhabilModel;

class DiasInhabiles extends BaseController
{
    protected $model_diasInhabiles;
    protected $model_tipoDiaInhabil;
    protected $model_asignar_laboratorio;

    public function __construct()
    {
        $this->model_diasInhabiles = model(DiasInhabilesModel::class);
        $this->model_tipoDiaInhabil = model(TipoDiaInhabilModel::class);
        $this->model_asignar_laboratorio=model(AsignarLaboratorioModel::class);
    }

    public function index()
    {
        $dias = $this->model_diasInhabiles->obtenerDiasInhabiles();
      

        $data = [
            'dias' => $dias,
           
        ];

        print_r($data);
        return view('Labs/layouts/dias_inhabiles', $data);
    }

    public function nuevo()
    {
        helper('form');
        $tiposdia = $this->model_tipoDiaInhabil->obtenerTiposInhabiles();

        $data = [
            'tiposdia' => $tiposdia,
            'validation' => null,
            'success' => null,
        ];

        return view('Labs/layouts/agregar_dias_inhabiles', $data);
    }

    public function crear()
    {
        helper('form');
        $rules = $this->model_diasInhabiles->reglasValidacion();
        $tiposdia = $this->model_tipoDiaInhabil->obtenerTiposInhabiles();
        
        $data = [
            'id_tipo_inhabil' => $this->request->getPost('tipo_inhabil'),
            'descripcion' => $this->request->getPost('nombre'),
            'inicio' => $this->request->getPost('inicio'),
            'fin' => $this->request->getPost('fin'),
        ];

        if (!$this->validate($rules)) {
            return view('Labs/layouts/agregar_dias_inhabiles', [
                'tiposdia' => $tiposdia,
                'validation' => $this->validator,
                'success' => null,
            ]);
        }

        $this->model_diasInhabiles->insertarDiaInhabil($data);
        return redirect()->to('/diasinhabiles/nuevo')->with('success', 'Día inhabil creado con éxito.');
    }

    public function editar($id)
    {
        helper('form');

        try {
            $diaInhabil = $this->model_diasInhabiles->editarDiaInhabil($id);
            $tiposdia = $this->model_tipoDiaInhabil->obtenerTiposInhabiles();

            return view('Labs/layouts/editar_dias_inhabiles', [
                'dia' => $diaInhabil,
                'tipos' => $tiposdia,
                'validation' => null
            ]);
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            return redirect()->to('/diasinhabiles')->with('error', $e->getMessage());
        }
    }
    

    public function actualizar($id)
    {
        helper('form');
        
        $rules = $this->model_diasInhabiles->reglasValidacion();
        
        $data = [
            'id_tipo_inhabil' => $this->request->getPost('tipo_inhabil'),
            'descripcion' => $this->request->getPost('nombre'),
            'inicio' => $this->request->getPost('inicio'),
            'fin' => $this->request->getPost('fin'),
        ];

        if (!$this->validate($rules)) {
            return view('Labs/layouts/editar_dias_inhabiles', [
                'dia' => $this->model_diasInhabiles->editarDiaInhabil($id),
                'tipos' => $this->model_tipoDiaInhabil->obtenerTiposInhabiles(),
                'validation' => $this->validator
            ]);
        }

        try {
            $this->model_diasInhabiles->actualizarDiaInhabil($id, $data);
            return redirect()->to("/diasinhabiles/editar/$id")->with('success', 'Día inhabil actualizado con éxito.');
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            return redirect()->to('/diasinhabiles')->with('error', $e->getMessage());
        } catch (\RuntimeException $e) {
            return redirect()->to("/diasinhabiles/editar/$id")->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->to('/diasinhabiles')->with('error', 'Ocurrió un error inesperado.');
        }
    }

    public function eliminar($id)
    {
        try {
            $this->model_diasInhabiles->eliminarDiaInhabil($id);
            return redirect()->to('/diasinhabiles')->with('success', 'Día inhabil eliminado con éxito.');
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            return redirect()->to('/diasinhabiles')->with('error', $e->getMessage());
        } catch (\RuntimeException $e) {
            return redirect()->to('/diasinhabiles')->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->to('/diasinhabiles')->with('error', 'Ocurrió un error inesperado al intentar eliminar el día inhabil.');
        }
    }
}
