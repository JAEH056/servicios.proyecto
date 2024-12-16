<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ErrorWorker extends BaseController
{
    public function index()
    {
        return view('/error');
    }
}
