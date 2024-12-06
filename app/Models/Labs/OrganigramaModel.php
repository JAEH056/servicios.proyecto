<?php
    namespace App\Models\Labs;


    class OrganigramaModel extends UserModel{

        protected $table      = 'organigrama';
        protected $primaryKey = 'id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = true;

        protected $allowedFields = ['nombreM','nombreF','cargo','izquierda','derecha'];

    }