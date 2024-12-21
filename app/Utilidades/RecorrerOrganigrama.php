<?php

namespace App\Utilidades;

use App\Models\PuestoEmpleado\OrganigramaModel;

class RecorrerOrganigrama
{
    protected $model_organigrama;

    public function __construct()
    {
        $this->model_organigrama = model(OrganigramaModel::class);
    }

    /**
     * Recorrer el organigrama de manera más eficiente sin recursión.
     *
     * @param int|null $izquierda
     * @param int|null $derecha
     * @return array
     */
    public function recorrerOrganigrama($izquierda = null, $derecha = null)
    {
        // Si $izquierda y $derecha son nulos, obtenemos todo el organigrama
        if ($izquierda === null && $derecha === null) {
            $cargos = $this->model_organigrama->orderBy('izquierda', 'ASC')->findAll();
        } else {
            // Si tenemos un límite izquierdo y derecho, filtramos directamente desde la base de datos
            $cargos = $this->model_organigrama
                ->where('izquierda >', $izquierda)
                ->where('derecha >', $derecha)
                ->orderBy('izquierda', 'ASC')
                ->findAll();
        }

        return $cargos;
    }

    /**
     * Método que inicializa el recorrido del organigrama.
     *
     * @return array
     */
    public function verOrganigrama()
    {
        // Llamamos al método recorrerOrganigrama
        return $this->recorrerOrganigrama();
    }
}
