<?php

    namespace App\Controllers\Labs;

use App\Controllers\BaseController;

    class Prueba extends BaseController
    {
        public function iniciando(): string
        {
            return view('Labs/layouts/semestre');
        }
    }