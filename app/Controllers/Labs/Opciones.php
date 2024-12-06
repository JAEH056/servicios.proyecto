<?php

    namespace App\Controllers\Labs;

    class Opciones extends MyController
    {
        public function opciones(): string
        {
            return view('Labs/layouts/opciones');
        }
    }