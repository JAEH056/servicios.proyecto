<?php

    namespace App\Models\Labs;


    class LaboratorioModel extends UserModel
    {

        protected $table      = 'laboratorio';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;
        protected $returnType     = \App\Entities\Labs\Laboratorio::class;
        protected $useSoftDeletes = false;
        protected $allowedFields = ['id_carrera', 'nombre'];

        public function obtenerLaboratorios()
        {


            $sql = <<<EOL
            SELECT 
                laboratorio.id AS id,
                carrera.id AS carrera_id,
                carrera.nombre AS carrera_nombre,
                laboratorio.nombre AS nombre_laboratorio
            FROM 
                laboratorio
            JOIN carrera ON carrera.id = laboratorio.id_carrera
            GROUP BY laboratorio.id
            EOL;

            $query = $this->db->query($sql);
            $laboratorios = $query->getResultArray();
            return $laboratorios;
        }

        public function reglasValidacion()
        {

            return [
                'nombre' => [
                    'rules' => 'required|max_length[255]|min_length[8]',
                    'errors' => [
                        'required' => 'El nombre es obligatorio.',
                        'max_length' => 'El nombre no puede tener más de 255 caracteres.',
                        'min_length' => 'El nombre debe tener al menos 8 caracteres.'
                    ],
                ],

                'id_carrera' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Seleccionar carrera no es una opcion válida',
                        'integer' => 'Selección no válido.'
                    ],
                ],
            ];
        }

        public function insertarLaboratorio($data)
        {
            return $this->insert($data);
        }

        public function editarLaboratorio($id)
        {
            $laboratorio = $this->find($id);
            if (!$laboratorio) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("El laboratorio con ID $id no existe.");
            }
            return $laboratorio;
        }


        public function actualizarLaboratorio($id, $data)
        {
            $laboratorio = $this->find($id);

            if (!$laboratorio) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException("El laboratorio con ID $id no existe.");
            }

            if (!$this->update($id, $data)) {
                throw new \RuntimeException("Error al actualizar el laboratorio con ID $id.");
            }
            return true;
        }


        public function eliminarLaboratorio($id)
        {
            $laboratorio = $this->find($id);
            if (!$laboratorio) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException("El laboratorio con ID $id no existe.");
            }
            $result = $this->delete($id);
            if (!$result) {
                throw new \RuntimeException("No se pudo eliminar el laboratorio con ID $id.");
            }
            return true;
        }
    }
