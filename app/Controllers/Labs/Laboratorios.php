<?php

namespace App\Controllers\Labs;

use App\Controllers\My;
use App\Models\Labs\EmployeeModel;
use App\Models\Labs\ProjectModel;

class MyController extends MyController
{
    public function index()
    {
      //  $employeeModel = new EmployeeModel();
      //  $projectModel = new ProjectModel();

    
       // $employees = $employeeModel->findAll();

        
       // $projects = $projectModel->findAllWithLimit(10);

        // Pasar los datos a la vista
        return view('dashboard', [
           // 'employees' => $employees,
          //  'projects' => $projects,
        ]);
    }
}
