<?php

//namespace App\Controllers;
namespace App\Controllers\Reposs;

use App\Controllers\BaseController;

class OpenUseController extends BaseController
{
    public function index(): string
    {
        return view('Reposs/dashboard');
    }
}
