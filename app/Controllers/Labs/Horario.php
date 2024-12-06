<?php

    namespace App\Controllers\Labs;

    class Horario extends MyController
    {
        public function iniciando(): string
        {
            return view('Labs/layouts/horario');
        }
    }