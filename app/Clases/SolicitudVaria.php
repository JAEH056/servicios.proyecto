<?php

namespace App\Clases;

class SolicitudVaria extends SolicitudAbstracta {

    public const TIPO_SOLICITUD = "varia";

    public int $tipoUso;
    public string $descripcion; // Actividades que se realizán.

    public string $tipo = self::TIPO_SOLICITUD;
    public function __construct(
        string $nombre,
        string $solicitante,
        \DateTimeInterface $inicio,
        \DateTimeInterface $fin,
        \DateTimeInterface $fechaSolicitud,
        int $autorizado,
        int $tipoUso,
        string $descripcion,
        int $idSolicitud,
    ) {
        $this->nombre         = $nombre;
        $this->solicitante    = $solicitante;
        $this->inicio         = $inicio;
        $this->fin            = $fin;
        $this->fechaSolicitud = $fechaSolicitud;
        $this->autorizado     = $autorizado;
        $this->tipoUso        = $tipoUso;
        $this->descripcion    = $descripcion;
        $this->idSolicitud   = $idSolicitud;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function getTipoUso(): int {
        return $this->tipoUso;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }
    public function estaAutorizado(): int {
        return $this->autorizado;

    }
    public function getSolicitud(): int{
        return $this->idSolicitud;
    }

}