<?php

namespace App\Clases;

interface Solicitud {
    
   public const AUTORIZACION_ENPROCESO = 0;
   public const AUTORIZACION_RECHAZADA = 2;
   public const AUTORIZACION_AUTORIZADA =1;

   public function getNombre(): string;
   public function getSolicitante(): string;
   public function getInicio(): \DateTimeInterface;
   public function getFin(): \DateTimeInterface;
   public function getFechaSolicitud(): \DateTimeInterface;
   public function getTipo(): string;
   public function estaAutorizado(): int;
   public function getObservaciones(): string;
   // para obtener que id de solicitud es
   public function getSolicitud():int;


}