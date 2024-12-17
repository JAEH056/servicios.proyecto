<?php

namespace App\Controllers\Labs;

use App\Controllers\BaseController;
use App\Models\Labs\DiasInhabilesModel;
use App\Models\Labs\HorarioModel;
use App\Models\Labs\LaboratorioModel;

class CrearHorario extends BaseController
{
    protected $model_horario;
    protected $model_laboratorio;
    protected $model_dias_inhabiles;

    public function __construct()
    {
        $this->model_horario = model(HorarioModel::class);
        $this->model_laboratorio = model(LaboratorioModel::class);
        $this->model_dias_inhabiles = model(DiasInhabilesModel::class);
    }

    public function verHorario($idLaboratorio = null)
    {
        $periodos = $this->model_horario->obtenerHorariosPorLaboratorio($idLaboratorio);
        $laboratorios = $this->model_laboratorio->obtenerLaboratorios();

        if (!$idLaboratorio && !empty($laboratorios)) {
            return redirect()->to(base_url("horario/" . $laboratorios[0]['id']));
        }

        if (empty($periodos)) {
            return view('Labs/layouts/error_404', ['mensaje' => 'No se encontraron periodos para el laboratorio.']);
        } else {
            foreach ($periodos as $datosperiodo) {
                if (isset($datosperiodo['inicio']) && isset($datosperiodo['fin'])) {
                    $inicioPeriodo = $datosperiodo['inicio'];
                    $finPeriodo = $datosperiodo['fin'];
                }
            }
        }

            // Obtener días inhábiles para el periodo seleccionado
            $diasInhabilesPeriodo = $this->model_dias_inhabiles->obtenerDiasInhabilesPorPeriodo($inicioPeriodo, $finPeriodo);

            // Procesar días inhábiles
            $eventos = [];
            if (!empty($diasInhabilesPeriodo)) {
                foreach ($diasInhabilesPeriodo as $datosevento) {
                    $raw = [
                        'tipo_inhabil' => $datosevento['tipo_inhabil'],
                    ];
                    $eventos[] = [
                        'id'    => $datosevento['id'],
                        'title' => $datosevento['nombre'],
                        'start' => (new \DateTimeImmutable($datosevento['inicio']))->format('Y-m-d 00:00:00'),
                        'end'   => (new \DateTimeImmutable($datosevento['fin']))->format('Y-m-d 23:59:59'),
                        'raw'   => $raw,
                    ];
                }
            }

            //prueba datos para un evento 
            $eventos1[] = [
               
                    'id'    => '70',
                    'title' => 'practica',
                    'start' => '2025-02-03 08:00',
                    'end'   => '2025-02-03 09:30',
                
            ];
            $eventos2[] = [
               
                'id'    => '70',
                'title' => 'clase',
                'start' => '2025-02-03 09:30',
                'end'   => '2025-02-03 10:30',
            
        ];
        $eventos3[] = [
               
            'id'    => '70',
            'title' => 'practica',
            'start' => '2025-02-03 08:00',
            'end'   => '2025-02-03 11:30',
        
    ];
    $eventos4[] = [
       
        'id'    => '70',
        'title' => 'clase',
        'start' => '2025-02-03 10:30',
        'end'   => '2025-02-03 11:30',
    
];
            $todosLosEventos = array_merge($eventos,$eventos1,$eventos2,$eventos2,$eventos4);

            $data = [];
            if (!empty($periodos)) {
                foreach ($periodos as $datosperiodo) {
                    $data = [
                        'periodoJson' => json_encode([


                            'inicio' => $datosperiodo['inicio'],
                            'fin' => $datosperiodo['fin'],


                        ]),
                        'laboratorios' => $laboratorios,
                        'laboratorioSeleccionado' => $idLaboratorio,
                        'events' => json_encode($todosLosEventos),
                       
                       
                    ];
                }
              
                print_r($data);
            }
            return view('Labs/layouts/horarios', $data);
        
    }
}
