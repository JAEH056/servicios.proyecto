<?php

namespace App\Models\PuestoEmpleado;

use CodeIgniter\Model;

class GradoAcademicoModel extends Model
{
    protected $DBGroup = 'compartida';
    protected $table = 'grado_academico';
    protected $primaryKey = 'idgrado_academico';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'idnivel',
        'idusuario',
        'nombre_grado',
        'programa_educativo',
        'siglas',
        'fecha_creacion',
    ];

    public function insertarGradoAcademico($data)
    {
        return $this->insert($data);
    }
    public function obtenerGrado($userId)
    {
        $builder = $this->db->table($this->table)
            ->select('nivel.nombre_nivel,nombre_grado,programa_educativo,siglas,fecha_creacion')
            ->join('nivel', 'nivel.idnivel=grado_academico.idnivel')
            ->join('usuario', 'usuario.idusuario=grado_academico.idusuario')
            ->where('grado_academico.idusuario', $userId);
        $query = $builder->get();
        $grados = $query->getResultArray();
        return $grados;

        // $gradousuario = [];
        // foreach ($grados as $grado) {
        //     $gradousuario= [
                
                
        //         'nombre_nivel' => $grado['nombre_nivel'],
        //         'nombre_grado' => $grado['nombre_grado'],
        //         'programa_educativo'=>$grado['programa_educativo'],
        //         'siglas'=>$grado['siglas'],
        //         'fecha_creacion'=>$grado['fecha_creacion']

        //       ];
        // }
       
        // return $gradousuario;
    }

    public function reglasValidacion()
    {
        return [
            'idnivel' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'El nivel es obligatorio',
                    'integer' => ''
                ]
            ],
            'nombre_grado' => [
                'rules' => 'required|max_length[45]|min_length[8]',
                'errors' => [
                    'required' => 'El grado es obligatorio',
                    'max_length' => 'El grado academico no puede tener más de 45 caracteres.',
                    'min_length' => 'El grado academico debe tener al menos 8 caracteres.'
                ]
            ],
            'programa_educativo' => [
                'rules' => 'required|max_length[45]|min_length[8]',
                'errors' => [
                    'required' => 'El programa educativo es obligatorio',
                    'max_length' => 'El programa  educativo no puede tener más de 45 caracteres.',
                    'min_length' => 'El programa educativo debe tener al menos 8 caracteres.'

                ]
            ],
            'siglas' => [
                'rules' => 'required|max_length[45]|min_length[3]',
                'errors' => [
                    'required' => 'Las siglas del grado academico son requeridas',
                    'max_length' => 'Las siglas no pueden tener más de 45 caracteres.',
                    'min_length' => 'Las siglas deben tener al menos 3 caracteres.'

                ]
            ],
            'fecha_creacion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'campo obligatorio',


                ]
            ],
        ];
    }
}
