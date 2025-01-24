<?php

namespace App\Controllers\OAuthlogin;

use App\Models\PuestoEmpleado\OrganigramaModel;
use App\Models\PuestoEmpleado\PuestoEmpleadoModel;
use CodeIgniter\Controller;
use League\OAuth2\Client\Provider\GenericProvider;
use App\Models\Reposs\UserModel;
use App\Models\Roles\UserRolesModel;
use App\Models\Reposs\ResidenteModel;
use Config\OAuth;

class OAuthController extends Controller
{
    protected $microsoftProvider;
    protected $rbac;
    protected $userModel;
    protected $userRolesModel;
    protected $residenteModel;
    protected $modelo_organigrama;
    protected $modelo_puesto_empleado;


    public function __construct()
    {
        // Carga el proveedor de Microsoft OAuth desde la configuracion
        $credentials = (new OAuth())->credentials;
        $this->microsoftProvider = new GenericProvider([
            'clientId'                   => $credentials['clientId'],
            'clientSecret'               => $credentials['clientSecret'],
            'tenantId'                   => $credentials['tenantId'],  // Your Redirect URI
            'urlAuthorize'               => 'https://login.microsoftonline.com/' . $credentials['tenantId'] . '/oauth2/v2.0/authorize',
            'urlAccessToken'             => 'https://login.microsoftonline.com/' . $credentials['tenantId'] . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails'    => 'https://graph.microsoft.com/v1.0/me', // Microsoft Graph API endpoint to fetch user info
            'scopes'                     => ['openid profile offline_access user.read'],
        ]);
        // Se instancia el modelo
        $this->rbac = service('rbac');
        $this->userModel = new UserModel();
        $this->userRolesModel = new UserRolesModel();
        $this->residenteModel = new ResidenteModel();
        //para puesto empleado
        $this->modelo_organigrama = new OrganigramaModel();
        $this->modelo_puesto_empleado = new PuestoEmpleadoModel();
    }

    // Step 1: Redirect to Microsoft login page
    public function login()
    {
        // Generate the authorization URL
        $authorizationUrl = $this->microsoftProvider->getAuthorizationUrl();
        // Store the state in session to validate it later
        session()->set('oauth2state', $this->microsoftProvider->getState());
        // Redirect the user to the login URL
        return redirect()->to($authorizationUrl);
    }

    // Step 2: Handle the callback from Microsoft
    public function callback()
    {
        // Validate the state parameter to prevent CSRF
        if (empty($this->request->getGet('state')) || ($this->request->getGet('state') !== session()->get('oauth2state'))) {
            session()->remove('oauth2state');
            exit('Invalid state');
        }
        // Asegúrese de que el código está presente // Ensure the code is present
        if (empty($this->request->getGet('code'))) {
            exit('No code parameter found');
        }
        try {
            // Exchange the authorization code for an access token
            // Cambia el código de autorización por un token de acceso
            $accessToken = $this->microsoftProvider->getAccessToken('authorization_code', [
                'code' => $this->request->getGet('code')
            ]);
            // Use the access token to get the user information
            // Usa el token de acceso para obtener la informacion del usuario
            $resourceOwner = $this->microsoftProvider->getResourceOwner($accessToken);
            // Get the user info (profile)
            // Se guarda la informacion del usuario (Perfil de Microsoft Entra ID)
            $userData = $resourceOwner->toArray();  // Array containing user info
            // Store the access token and user information in session or database
            // Guarda el token de acceso y la informacion de usuario en la sesion o base de datos
            session()->set('logged_in', TRUE);
            session()->set('access_token', $accessToken);
            session()->set('name', $userData);
        } catch (\Exception $e) {
            //exit('Error fetching the access token: ' . $e->getMessage());
            log_message('error', 'Error fetching the access token: ' . $e->getMessage());
            return redirect()->to(base_url('/erroraut'))->with('message', 'There was an error with the authentication process.');
        }
        $emailParts = explode('@', $userData['userPrincipalName'], 2); /// Extrae el dominio del correo
        $domain = strtolower($emailParts[1]);
        // Arreglo con los Dominos permitidos
        $organizationDomain = [
            'alum.huatusco.tecnm.mx' => ['model' => $this->residenteModel, 'roleId' => 2, 'actualizarDatos' => '/usuario/residentes/datos', 'numero_control' => $emailParts[0]],
            'huatusco.tecnm.mx'      => ['model' => $this->userModel, 'roleId' => 3, 'actualizarDatos' => '/dashboard'],
        ];
        // Se define en una sola variable el modelo que se utilizara dependiendo del dominio (estudiante o Usuario).
        $tipoUsuario = $organizationDomain[$domain];
        // Si no existe el registro en la tabla correspondiente (definido por el dominio), se crea un nuevo registro.
        if ($tipoUsuario['model']->esPrimerIngreso($userData['userPrincipalName']) == true) {
            $this->guardarDatosDelUsuario($userData, $tipoUsuario);
        }
        // Si el usuario ya existe se le asignana el id de usuario a la sesion
        $userId = $this->getUserIdByEmail($userData['userPrincipalName']);
        // Actualizar la informacion del usuario (si es necesario)
        $actualiza = $tipoUsuario['model']->actualizarNombreUsuario($userData, $userId);
        if ($actualiza['success'] == false) {
            session()->setFlashdata('mensaje', $actualiza['mensaje']);
        }
        session()->set('idusuario', $userId);
        // Redirect the user to a secured page (e.g., dashboard)
        // Redirige al usuario para guardar los datos (e.g., dashboard)
        return redirect()->to(base_url('/dashboard'));
    }

    // Step 3: Display user data on the dashboard
    // Paso 3: Muestra la informacion del usuario en la pagina principal
    public function dashboard()
    {
        // Ensure the user is logged in
        if (!session()->has('name')) {
            return redirect()->to('/oauth/login');
        }

        $userId = session()->get('idusuario');
        $user = session()->get('name');
        $token = session()->get('access_token'); // linea para mandar los datos del Access token a la vista
        return view('dashboard/dashboard', ['user' => $user, 'token' => $token, 'idusuario' => $userId]); // Se agregan los datos a la vista
    }

    // Step 4: Logout and clear the session
    // Step 4: Cierra sesion y limpia la sesion
    public function logout()
    {
        // Se obtiene el cliente (inquilino)
        $credentials = (new OAuth())->credentials['tenantId'];
        // Se limpia la sesion
        session()->remove('idusuario');
        session()->remove('name');
        session()->remove('access_token');
        session()->destroy();
        // URL de logout de Microsoft
        $logoutUrl = "https://login.microsoftonline.com/" . $credentials . "/oauth2/v2.0/logout?post_logout_redirect_uri=" . urlencode(base_url('/'));
        // Redirigir al usuario a la URL de logout de Microsoft
        return redirect()->to($logoutUrl);
    }

    private function guardarDatosDelUsuario(array $datosUsuario, array $tipoUsuario)
    {
        // DATOS SANITIZADOS PARA ALMACENAR EN LA BASE DE DATOS
        if (empty($datosUsuario['surname']) === true) {
            $apellidos = null;
            $apellidos = [
                'apellido1' => 'na',
                'apellido2' => null
            ];
        } else {
            // Se separan los apellidos
            $apellido = $datosUsuario['surname'];
            $apellidos = $this->splitSurname($apellido); /// Separar apellidos
        }

        switch ($tipoUsuario['roleId']) {
            case 2:
                // ARREGLO CON LA INFORMACION DEL USUARIO (RESIDENTE)
                $dataResidente = [
                    'principal_name' => $datosUsuario['userPrincipalName'], /// Correo del usuario
                    'numero_control' => $tipoUsuario['numero_control'],     /// Numero de control
                    'nombre'         => $datosUsuario['givenName'],         /// Nombre completo
                    'apellido1'      => $apellidos['apellido1'],            /// Primer apellido
                    'apellido2'      => isset($apellidos['apellido2']) ? $apellidos['apellido2'] : null, // Segundo apellido
                ];
                // Insertar datos de usuario estudiante
                $this->residenteModel->insert($dataResidente);
                $idUsuario = (int)$this->residenteModel->InsertID();
                if (empty($idUsuario) === true) {
                    return redirect()->to(base_url('/error'))->with('error', 'Error al guardar los datos: Estudiante ' . $dataResidente['numero_control'] . ' ' . $dataResidente['nombre'] . ' ' . $dataResidente['apellido1'] . ' ' . $dataResidente['apellido2'] . ' ' . $dataResidente['principal_name'] . ' ' . $tipoUsuario['roleId']);
                }
                session()->set('idusuario', $idUsuario);
                $this->asignarRolAlUsuario($idUsuario, $tipoUsuario);
                break;
            case 3:
                // ARREGLO CON LA INFORMACION DEL USUARIO (EMPLEADO)
                $dataUsuario = [
                    'principal_name' => $datosUsuario['userPrincipalName'], /// Correo del usuario
                    'nombre'         => isset($datosUsuario['givenName']) ? $datosUsuario['givenName'] : 'na',         /// Nombre completo
                    'apellido1'      => $apellidos['apellido1'],            /// Primer apellido
                    'apellido2'      => isset($apellidos['apellido2']) ? $apellidos['apellido2'] : null, // Segundo apellido
                ];
                // Insertar datos de usuario empleado
                $this->userModel->insert($dataUsuario);
                $idUsuario = (int)$this->userModel->InsertID();
                if (empty($idUsuario) === true) {
                    return redirect()->to(base_url('/dashboard'))->with('error', 'Error al guardar los datos de usuario: Empleado' . ' ' . $dataUsuario['principal_name'] . ' ' . $dataUsuario['nombre'] . ' ' . $dataUsuario['apellido1']);
                }
                // Se le asigna un puesto al usuario
                $respuesta = $this->asignarPuesto($idUsuario, $datosUsuario['jobTitle']);
                if ($respuesta['success'] == false) {
                    return redirect()->to(base_url('/dashboard'))->with('error', 'Error al asignar el puesto: ');
                }
                session()->set('idusuario', $idUsuario);
                $this->asignarRolAlUsuario($idUsuario, $tipoUsuario);
                break;
        }
    }

    // Método para agregar el rol a la sesion (si no tiene uno se le asigna el rol de usuario)
    private function RolesdeUsuario(array $userData, array $tipoUsuario)
    {
        // Obtener el ID del usuario basado en el correo
        $idUsuario = $this->getUserIdByEmail($tipoUsuario['principal_name']);
        if (!$idUsuario || $idUsuario == 0) {
            session()->setFlashdata('error', 'No se encontró el usuario con el correo proporcionado.');
            return redirect()->to('/error');
        }
        // Verificar si el usuario tiene roles (en la tabla de roles)
        $userRoles = $this->userRolesModel->getUserRolesById($idUsuario);
        // Si no tiene roles, se le asigna un rol de usuario por defecto.
        if (!$userRoles) {
            try {
                // Obtener el ID del rol de 'Usuario'
                $roleId = $this->rbac->Roles->titleID('Usuario');
                // Asignar rol por defecto
                $this->rbac->Users->assign($roleId, $idUsuario);
                // Establecer el ID de usuario en la sesión
                session()->set('idusuario', $idUsuario);
                // Mensaje de éxito
                session()->setFlashdata('notification', 'Rol asignado con éxito al usuario: ' . $tipoUsuario['principal_name']);
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Hubo un error al asignar el rol al usuario.');
                log_message('error', 'Error al asignar rol: ' . $e->getMessage());
                return redirect()->to('/error')->with('message', 'Hubo un error al asignar el rol.');
            }
        }
        // Si el usuario ya tiene roles asignados
        session()->set('idusuario', $idUsuario);
        session()->setFlashdata('info', 'El correo ya está registrado y tiene roles asignados.');
        return true;
    }

    // Metodo para asignar roles a nuevos usuarios
    private function asignarRolAlUsuario(int $userId, array $tipoUsuario)
    {
        // Se le asigna el rol al usuario
        $this->rbac->Users->assign($tipoUsuario['roleId'], $userId);

        // Set flash data message with inserted data
        $redirect = (string)$tipoUsuario['actualizarDatos'];
        return redirect()->to(base_url($redirect))->with('notification', 'Usuario agregado!');
    }

    // Funcion para separar apellidos con varias palabras
    public function splitSurname(string $fullSurname): array
    {
        // Usa explode() para romper la cadena en piezas separadas por espacios.
        $parts = explode(" ", $fullSurname);
        // Se revisa si tiene mas de una palabra (to ensure it's a full name).
        if (count($parts) > 1) {
            // Se separa la ultima palabra como segundo apellido.
            $familySurname = array_pop($parts);
            // Se unen las palabras restantes como el primer apellido.
            $prefixOrFirstSurname = implode(" ", $parts);
            // Se regresan las dos partes en un arreglo.
            return [
                'apellido1' => $prefixOrFirstSurname,
                'apellido2' => $familySurname
            ];
        } else {
            // Si no hay un espacio se regresa la cadena original.
            return [
                'apellido1' => $fullSurname,
                'apellido2' => ''
            ];
        }
    }

    // Funcion para separar numero de control(estudiante) o nombre de usuario('docente')
    public function separarPrincipalname($userName)
    {
        // Usa explode() para romper la cadena en piezas separadas por espacios.
        $parts = explode("@", $userName);
        // Se revisa si tiene mas de una palabra (to ensure it's a full name).
        if (count($parts) > 1 && $parts[1] == 'alum.huatusco.tecnm.mx') {
            // Se separa la ultima palabra como segundo dominio.
            $dominio = array_pop($parts);
            // Se unen las palabras restantes como el primer apellido.
            $nombreUsuario = implode("", $parts);
            // Se regresan las dos partes en un arreglo.
            return [
                'nombreUsuario' => $nombreUsuario,
                'dominio' => $dominio
            ];
        }
        if ($parts[1] == 'huatusco.tecnm.mx') {
            // Se separa la ultima palabra como segundo dominio.
            $dominio = array_pop($parts);
            // Se unen las palabras restantes como el primer apellido.
            $nombreUsuario = implode("", $parts);
            // Se regresan las dos partes en un arreglo.
            return [
                'nombreUsuario' => $nombreUsuario,
                'dominio' => $dominio
            ];
        }
    }
    // Funcion para obtener el ID de usuario en caso de ser residente o usuario(puesto)
    private function getUserIdByEmail(string $correo): ?int
    {
        // Intentar obtener el ID del usuario de userModel
        $user = $this->userModel->select('idusuario')->where('principal_name', $correo)->first();
        if (isset($user)) {
            return (int) $user['idusuario'];
        }
        // Intentar obtener el ID del usuario de residenteModel
        $residente = $this->residenteModel->select('idresidente as idusuario')->where('principal_name', $correo)->first();
        if (isset($residente)) {
            return (int) $residente['idusuario'];
        }
        return 0;
    }

    // Se asigna el puesto del usuario dependiendo del parametro del perfil (jobtitle)
    private function asignarPuesto(int $userId, string $jobTitle): array
    {
        // Si no se ha asignado un título de trabajo, realizar búsqueda con un valor vacío
        if (empty($jobTitle) || $jobTitle === null) {
            return ['success' => false, 'mensaje' => 'No cuenta con un puesto de trabajo'];
        }
        // Buscar por el cargo específico
        $cargo = $this->modelo_organigrama->buscarCargoEmpleado($jobTitle);
        // Si no se encuentra el organigrama correspondiente
        if (!$cargo) {
            return ['success' => false, 'mensaje' => 'Puesto no encontrado en el organigrama'];
        }
        // Datos para asignar el puesto
        $data = [
            'idusuario' => $userId,
            'idorganigrama' => $cargo['idorganigrama'],
            'fecha_inicio' => date('Y-m-d'),
            'fecha_fin' => null, // Fecha de fin puede ser NULL si el puesto está activo
        ];
        try {
            // Insertar los datos en la base de datos
            $resultadoPuesto = $this->modelo_puesto_empleado->save($data);
            // Se le asigna el rol al usuario usando el modelo de organigrama
            $resultadoRol = $this->rbac->Users->assign($cargo['idorganigrama'], $userId);
            // Verificar si la inserción fue exitosa
            if (!$resultadoPuesto && !$resultadoRol) {
                return ['success' => false, 'mensaje' => 'Error al asignar el puesto'];
            }
            return redirect()->to(base_url('/dashboard'))->with('success', 'Puesto asignado correctamente');
        } catch (\Exception $e) {
            // En caso de error, mostrar el mensaje de la excepción
            return ['success' => false, 'mensaje' => 'Error al asignar el puesto: ' . $e->getMessage()];
        }
    }
}
