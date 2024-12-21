<?php

namespace App\Controllers\OAuthlogin;

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
        $rbac = service('rbac');
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
            // Redirect the user to a secured page (e.g., dashboard)
            // Redirige al usuario a una pagina segura (e.g., dashboard)
        } catch (\Exception $e) {
            //exit('Error fetching the access token: ' . $e->getMessage());
            log_message('error', 'Error fetching the access token: ' . $e->getMessage());
            return redirect()->to(base_url('/error'))->with('message', 'There was an error with the authentication process.');
        }
        /// INICIO DE BLOQUE DE DATOS DE USUARIO
        // Se extrae el nombre del usuario y correo
        $userPrincipalName = $userData['userPrincipalName'];
        $givenName = $userData['givenName'];
        $surname = $userData['surname'];
        $apellidos = $this->splitSurname($surname); // Separar apellidos
        $nombreDeUsuario = $this->separarPrincipalname($userPrincipalName);

        // Se crea un arreglo con la informacion del usuario
        $data = [
            'principal_name' => $userPrincipalName,
            'nombre' => $givenName,
            'apellido1' => $apellidos['apellido1'],  // Primer apellido
            'apellido2' => isset($apellidos['apellido2']) ? $apellidos['apellido2'] : '', // Segundo apellido
        ];

        // Extrae el dominio del correo
        $emailParts = explode('@', $data['principal_name']);
        if (count($emailParts) < 2) {
            exit('Formato de correo invalido.');
        }
        // Se modifica el correo a minusculas (para evitar problemas con mayusculas)
        $domain = strtolower($emailParts[1]);
        // Arreglo con los Dominos permitidos
        $organizationDomain = [
            'alum.huatusco.tecnm.mx' => ['model' => $this->residenteModel, 'roleId' => 2, 'actualizarDatos' => '/usuario/residentes/datos'],
            'huatusco.tecnm.mx' => ['model' => $this->userModel, 'roleId' => 3, 'actualizarDatos' => '/dashboard']
        ];
        // Verificar si el dominio es permitido
        if (!array_key_exists($domain, $organizationDomain)) {
            return redirect()->to('/error')->with('message', 'Dominio no valido');
        }

        // Se define en una sola variable el modelo que se utilizara dependiendo del dominio (estudiante o Usuario).
        $tipoUsuario = $organizationDomain[$domain];

        // Si no existe el registro en la tabla correspondiente (definido por el dominio), se crea un nuevo registro.
        if ($tipoUsuario['model']->esPrimerIngreso($userData['userPrincipalName']) == true) {
            $this->assignNewUserRole($data, $tipoUsuario);
        } else {
            $this->assignExistingUserRole($rbac, $data['principal_name']);
        } // El registro ya existe verificar roles y permisos
        /// FIN DE BLOQUE DE DATOS DE USUARIO
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

    // Método para agregar el rol a la sesion (si no tiene uno se le asigna el rol de usuario)
    private function assignExistingUserRole($rbac, string $correo)
    {
        // Obtener el ID del usuario basado en el correo
        $idUsuario = $this->getUserIdByEmail($correo);
        if (!$idUsuario) {
            session()->setFlashdata('error', 'No se encontró el usuario con el correo proporcionado.');
            return redirect()->to('/error');
        }
        // Verificar si el usuario tiene roles (en la tabla de roles)
        $userRoles = $this->userRolesModel->getUserRolesById($idUsuario);
        // Si no tiene roles, se le asigna un rol de usuario por defecto.
        if (!$userRoles) {
            try {
                // Obtener el ID del rol de 'Usuario'
                $roleId = $rbac->Roles->titleID('Usuario');
                // Asignar rol por defecto
                $rbac->Users->assign($roleId, $idUsuario);
                // Establecer el ID de usuario en la sesión
                session()->set('idusuario', $idUsuario);
                // Mensaje de éxito
                session()->setFlashdata('notification', 'Rol asignado con éxito al usuario: ' . $correo);
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Hubo un error al asignar el rol al usuario.');
                log_message('error', 'Error al asignar rol: ' . $e->getMessage());
                return redirect()->to('/error')->with('message', 'Hubo un error al asignar el rol.');
            }
        }
        // Si el usuario ya tiene roles asignados
        session()->set('idusuario', $idUsuario);
        session()->setFlashdata('info', 'El correo ya está registrado y tiene roles asignados.');
        return redirect()->to('/error');
    }

    // Metodo para asignar roles a nuevos usuarios
    private function assignNewUserRole(array $data, $usuario)
    {
        if (!$idUsuario = $usuario['model']->insert($data)) {
            return redirect()->to('/error')->with('message', 'Error al insertar los datos del usuario.');
        }
        $this->rbac->Users->assign($usuario['roleId'], $idUsuario);
        session()->set('idusuario', $idUsuario);
        // Set flash data message with inserted data
        $redirect = $usuario['actualizarDatos'];
        return redirect()->to(base_url($redirect))->with('notification', 'Usuario agregado!, Primera vez ' . $data['nombre'] . ' ' . $data['apellido1'] . ' ? (' . $data['principal_name'] . ')');
    }

    // Funcion para separar apellidos con varias palabras
    public function splitSurname($fullSurname)
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
        return null;
    }
}
