<?php

    namespace App\Controllers\Labs;

    class Horario extends MyController
    {
        public function index(): string
        {
            return view('Labs/layouts/horario');
        }
    }