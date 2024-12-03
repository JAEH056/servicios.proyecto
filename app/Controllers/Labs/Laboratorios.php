<?php

namespace App\Controllers\Labs;
use \App\Models\Labs\LaboratorioModel;

class  Laboratorios extends MyController
{
    public function mostrarLaboratorios(int $LaboratoriosID)
    {
        $laboratoriosModel = new LaboratorioModel();

        $lista_laboratorio = $laboratoriosModel->obtenerLaboratorios();
       
        $lista_laboratorios = [];

       
        foreach ($lista_laboratorio as $data) {
            
            $lista_laboratorios[] =[

                "carrera" => $data['laboratorio'], 
                "laboratorio" => $data['carrera'] 
                
           ];
            print_r($lista_laboratorios);
        }

        
        return view('Labs/layouts/laboratorio', ['lista_laboratorios'=>$lista_laboratorios]);
    }

    public function actualizarLaboratorio($labID){
        $datosLaboratorio=[
         
         $titulo = $this->request->getPost('nombre'),
         $carrera =$this->request->getPost('carrera')
       
        ];
        
     $insertarlaboratorio =new LaboratorioModel();
     
     $laboratorio=  $insertarlaboratorio -> actualizarLaboratorio ($datosLaboratorio);
     if($laboratorio){
        return redirect()->to('Labs/layouts/laboratorio')->with('Actualizado','Laboratorioactualizado');
    } else {
      
       echo 'error', 'Hubo un error al crear el evento.';
    
     }

    }

   
}
