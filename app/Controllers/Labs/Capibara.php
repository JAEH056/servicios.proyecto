<?php

namespace App\Controllers\Labs;

use App\Controllers\BaseController;
use App\Clases\Solicitud;
use App\Clases\SolicitudVaria;
use App\Clases\SolicitudPractica;

class Capibara extends BaseController {

    public function datosSolicitud() {
        $id = 8;

        $solicitud = $this-> buscarSolicitud($id);
        $solicitudJson = json_encode($solicitud);
        
        return view('Labs/capibara', [
            'solicitud' => $solicitud,
        ]);
    }
    
    protected function buscarSolicitud(int $id): ?Solicitud {
        switch($id) {
            case 8:
                return new SolicitudVaria(
                    'Bailable de piez descalzos',
                    'juan',
                    new \DateTimeImmutable('2024-01-23'),
                    new \DateTimeImmutable('2024-02-14'),
                    new \DateTimeImmutable('2024-01-16'),
                    Solicitud::AUTORIZACION_ENPROCESO,
                    1,
                    'Practicar para el evento de fin de año en el tecnológico de NoSeDondeTa.'
                );
            case 9:
                return new SolicitudPractica(
                    'Crear instancias de tablas',
                    'Cahyamán',
                    new \DateTimeImmutable('2024-01-23'),
                    new \DateTimeImmutable('2024-02-14'),
                    new \DateTimeImmutable('2024-01-16'),
                    Solicitud::AUTORIZACION_ENPROCESO,
                    ['carrera' => 'ÍSC', 'Administración de bases de datos', '604B'],
                    'Hacer consultas.'
                );
        }

        return null;
    }

}