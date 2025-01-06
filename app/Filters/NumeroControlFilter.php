<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;


class NumeroControlFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Obtener el número de control desde la URL
        $uri = $request->getUri();
        $segments = $uri->getSegments();
        $numeroControl = end($segments); // Asumiendo que el número de control es el último segmento de la URL

        // Validar el número de control con la expresión regular
        if (!preg_match('/^[a-z]?\d{3}z\d{4}$/', $numeroControl)) {
            return redirect()->to('/acceso-denegado')->with('message', 'Número de control inválido: ' . $numeroControl);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita implementar nada aquí...
    }
}
