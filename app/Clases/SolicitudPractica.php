<?php

namespace App\Clases;

class SolicitudPractica extends SolicitudAbstracta {

    protected const TIPO_SOLICITUD = "practica";

    public array $clase;
    public string $objetivo;

    public string $tipo = self::TIPO_SOLICITUD;

    public function __construct(
        string $nombre,
        string $solicitante,
        \DateTimeInterface $inicio,
        \DateTimeInterface $fin,
        \DateTimeInterface $fechaSolicitud,
        int $autorizado,
        array $clase,
        string $objetivo,
        int $idSolicitud,
    ) {
        $this->nombre         = $nombre;
        $this->solicitante    = $solicitante;
        $this->inicio         = $inicio;
        $this->fin            = $fin;
        $this->fechaSolicitud = $fechaSolicitud;
        $this->autorizado     = $autorizado;
        $this->clase          = $clase;
        $this->objetivo       = $objetivo;
        $this->idSolicitud   = $idSolicitud;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function getClase(): array{
        return $this->clase;
    }

    public function getObjetivo(): string {
        return $this->objetivo;
    }
    public function getSolicitud(): int{
        return $this->idSolicitud;
    }
    

}