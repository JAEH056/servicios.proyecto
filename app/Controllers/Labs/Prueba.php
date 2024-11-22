<?php

namespace App\Controllers\Labs;

class Prueba extends MyController
{
    public function iniciando(): string
    {
        return view('Labs/layouts/login');
    }
}
    