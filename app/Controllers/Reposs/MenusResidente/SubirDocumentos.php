<?php

namespace App\Controllers\Reposs\MenusResidente;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class SubirDocumentos extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index(): ResponseInterface|string
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('Reposs/MenusResidente/subirDocumentos', ['user' => $user, 'token' => $token, 'idusuario' => $userId]); // Se agregan los datos a la vista
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null): void
    {
        //
    }
        /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function submit(): ResponseInterface|string
    {
        $validation = \Config\Services::validation();

        // Set validation rules for file upload
        $validation->setRules([
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]|max_size[file, 2048]|ext_in[file,pdf]',
                'errors' => [
                    'uploaded' => 'You must choose a file to upload.',
                    'max_size' => 'The file size cannot exceed 2MB.',
                    'ext_in' => 'Only PDF files are allowed.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // If validation fails, return to the upload form with errors
            return view('upload_form', [
                'validation' => $validation
            ]);
        }

        // File upload handling
        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            // Define upload path
            $uploadPath = WRITEPATH . 'uploads/';

            // Move the file to the specified directory
            $file->move($uploadPath);

            // Show success message
            return redirect()->to('/usuario/residentes/documentos')->with('message', 'File uploaded successfully!');
        } else {
            return redirect()->to('/usuario/residentes/documentos')->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new(): void
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create(): void
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null): void
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null): void
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null): void
    {
        //
    }
}
