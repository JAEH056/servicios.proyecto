<?php

namespace App\Controllers\Labs;

use \App\Models\Labs\SemestreModel;

class Semestre extends MyController
{
    public function index()
    {
        $model = model(SemestreModel::class);
        $semestre = $model->obtenerSemestre();
        $data = [
            'semestre' => $semestre,
            'title' => 'Lista de Semestres',
        ];
        return view('Labs/layouts/semestre', $data);
    }

    private function reglasValidacion()
    {
        return [
            'nombre' => [
                'rules' => 'required|max_length[255]|min_length[8]',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                    'min_length' => 'El nombre debe tener al menos 8 caracteres.'
                ],
            ],
            'inicio' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de inicio es obligatoria.',
                    'valid_date' => 'La fecha de inicio no es válida.',
                ],
            ],
            'fin' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de fin es obligatoria.',
                    'valid_date' => 'La fecha de fin no es válida.',
                ],
            ],
        ];
    }

    public function nuevo()
    {
        helper('form');
        $data = [
            'title' => 'Agregar Semestre',
            'validation' => null,
            'success' => null,  // Para pasar el mensaje de éxito
        ];
        return view('Labs/layouts/agregar_semestre', $data);
    }

    public function crear()
    {
        helper('form');

        $data = $this->request->getPost(['nombre', 'inicio', 'fin']);

        // Validar las reglas generales
        if (!$this->validate($this->reglasValidacion())) {
            return view('Labs/layouts/agregar_semestre', [
                'title' => 'Agregar Semestre',
                'validation' => \Config\Services::validation(),
                'success' => null,
            ]);
        }

        // Validar que la fecha de fin sea posterior a la fecha de inicio
        if (strtotime($data['fin']) <= strtotime($data['inicio'])) {
            \Config\Services::validation()->setError('fin', 'La fecha de fin debe ser posterior a la fecha de inicio.');
            return view('Labs/layouts/agregar_semestre', [
                'title' => 'Agregar Semestre',
                'validation' => \Config\Services::validation(),
                'success' => null,
            ]);
        }

        $model = model(SemestreModel::class);
        $model->save([
            'nombre' => $data['nombre'],
            'inicio' => $data['inicio'],
            'fin' => $data['fin'],
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->to('/semestre/nuevo')->with('success', 'Semestre agregado con éxito.');
    }

    public function editar($id)
    {
        helper('form');
        $model = model(SemestreModel::class);
        $semestre = $model->find($id);  // Obtener el semestre con el ID
    
        if (!$semestre) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Semestre con ID $id no encontrado.");
        }
    
        return view('Labs/layouts/editar_semestre', [
            'title' => 'Editar Semestre',
            'semestre' => $semestre,  // Pasar los datos del semestre a la vista
            'validation' => null,
            'success' => session()->getFlashdata('success'),  // Pasar mensaje de éxito si existe
        ]);
    }
    
    public function actualizar($id)
    {
        helper('form');
    
        // Obtener los datos del formulario
        $data = $this->request->getPost(['nombre', 'inicio', 'fin']);
    
        // Validar las reglas generales
        if (!$this->validate($this->reglasValidacion())) {
            // Obtener el registro del semestre con el ID para volver a cargar la vista
            $model = model(SemestreModel::class);
            $semestre = $model->find($id);
    
            return view('Labs/layouts/editar_semestre', [
                'title' => 'Editar Semestre',
                'semestre' => $semestre,  // Volver a cargar los datos del semestre
                'validation' => \Config\Services::validation(),
            ]);
        }
    
        // Validar que la fecha de fin sea posterior a la fecha de inicio
        if (strtotime($data['fin']) <= strtotime($data['inicio'])) {
            \Config\Services::validation()->setError('fin', 'La fecha de fin debe ser posterior a la fecha de inicio.');
    
            // Obtener el registro del semestre con el ID para volver a cargar la vista
            $model = model(SemestreModel::class);
            $semestre = $model->find($id);
    
            return view('Labs/layouts/editar_semestre', [
                'title' => 'Editar Semestre',
                'semestre' => $semestre,  // Volver a cargar los datos del semestre
                'validation' => \Config\Services::validation(),
            ]);
        }
    
        // Actualizar los datos en la base de datos
        $model = model(SemestreModel::class);
        $model->update($id, [
            'nombre' => $data['nombre'],
            'inicio' => $data['inicio'],
            'fin' => $data['fin'],
        ]);
    
        // Redirigir con mensaje de éxito
        return redirect()->to('/semestre/editar/' .$id)->with('success', 'Semestre actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $model = model(SemestreModel::class);


        $semestre = $model->find($id);
        if (!$semestre) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("El registro con ID $id no existe.");
        }


        if ($model->delete($id)) {

            return redirect()->to('semestre')->with('success', 'Registro eliminado correctamente.');
        } else {

            return redirect()->to('semestre')->with('error', 'No se pudo eliminar el registro.');
        }
    }
    

        
}
