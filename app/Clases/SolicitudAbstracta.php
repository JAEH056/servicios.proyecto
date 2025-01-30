<?php

namespace App\Clases;

abstract class SolicitudAbstracta implements Solicitud {

    public string $nombre;
    public string $solicitante;
    public \DateTimeInterface $inicio;
    public \DateTimeInterface $fin;
    public \DateTimeInterface $fechaSolicitud;
    public int $autorizado;
    public string $observaciones = '';
    public int $idSolicitud;

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getSolicitante(): string {
        return $this->solicitante;
    }

    public function getInicio(): \DateTimeInterface {
        return $this->inicio;
    }

    public function getFin(): \DateTimeInterface {
        return $this->fin;
    }

    public function getFechaSolicitud(): \DateTimeInterface {
        return $this->fechaSolicitud;
    }

    public function estaAutorizado(): int {
        return $this->autorizado;
    }

    public function getObservaciones(): string {
        if($this->autorizado == self::AUTORIZACION_ENPROCESO) {
            throw new \Exception('Trato de obtener las observaciones cuando la solicitud esta en proceso.');
        }
        return $this->observaciones;
    }
    public function getSolicitud(): int{
        return $this->idSolicitud;
    }
}