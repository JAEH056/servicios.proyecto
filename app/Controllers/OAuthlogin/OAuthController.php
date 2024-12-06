<?php

namespace App\Controllers\OAuthlogin;

use CodeIgniter\Controller;
use League\OAuth2\Client\Provider\GenericProvider;
use App\Models\Reposs\UserModel;
use App\Models\Roles\UserRolesModel;
use Config\OAuth;

class OAuthController extends Controller
{
    protected $microsoftProvider;

    public function __construct()
    {
        // Carga el proveedor de Microsoft OAuth desde la configuracion
        $credentials = (new OAuth())->credentials;
        $this->microsoftProvider = new GenericProvider([
            'clientId' => $credentials['clientId'],
            'clientSecret' => $credentials['clientSecret'],
            'tenantId' => $credentials['tenantId'],  // Your Redirect URI
            'urlAuthorize' => 'https://login.microsoftonline.com/' . $credentials['tenantId'] . '/oauth2/v2.0/authorize',
            'urlAccessToken' => 'https://login.microsoftonline.com/' . $credentials['tenantId'] . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me', // Microsoft Graph API endpoint to fetch user info
            'scopes' => ['openid profile offline_access user.read'],
        ]);
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

            //Se extrae el nombre del usuario y correo
            $userPrincipalName = $userData['userPrincipalName'];
            $givenName = $userData['givenName'];
            $surname = $userData['surname'];

            // Se instancia el modelo
            $userModel = new UserModel();
            $userRolesModel = new UserRolesModel();
            $rbac = service('rbac');

            // Se crea un arreglo con la informacion del usuario
            $data = [
                'correo' => $userPrincipalName,
                'nombre' => $givenName,
                'apellido1' => $surname
            ];

            // Verificar si el correo ya existe en la base de datos
            $existingRecord = $userModel->findByCorreo($userPrincipalName);

            if (!$existingRecord) {
                // Si no existe el registro, crear un nuevo usuario y se le asigna un rol por defecto
                $this->assignNewUserRole($userModel, $data);
            } else {
                // El registro ya existe, manejar la situación (por ejemplo, mostrar un mensaje)
                echo "El correo ya está registrado.";
                $this->assignExistingUserRole($userModel, $userRolesModel, $rbac, $data['correo']);
            }
            // Store the access token and user information in session or database
            // Guarda el token de acceso y la informacion de usuario en la sesion o base de datos
            session()->set('logged_in', TRUE);
            session()->set('access_token', $accessToken);
            session()->set('name', $userData);

            // Redirect the user to a secured page (e.g., dashboard)
            // Redirige al usuario a una pagina segura (e.g., dashboard)
            return redirect()->to('/dashboard');
        } catch (\Exception $e) {
            //exit('Error fetching the access token: ' . $e->getMessage());
            log_message('error', 'Error fetching the access token: ' . $e->getMessage());
            return redirect()->to('/dashboard')->with('auth_message', 'There was an error with the authentication process.');
        }
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
        session()->set('logged_in', FALSE);
        session()->remove('idusuario');
        session()->remove('name');
        session()->remove('access_token');
        return redirect()->to(base_url('/'));
    }

    // Método para agregar el rol a la sesion (si no tiene uno se le asigna el rol de usuario)
    private function assignExistingUserRole(UserModel $userModel, UserRolesModel $userRolesModel, $rbac, string $correo)
    {
        // Obtener el ID del usuario basado en el correo
        $idUsuario = $userModel->select('idusuario')->where('correo', $correo)->first();
        if ($idUsuario) {
            // Verificar si el usuario tiene roles
            $userRoles = $userRolesModel->getUserRolesById($idUsuario['idusuario']);
            //$result = $rbac->Users->roleCount($idUsuario);

            if (!$userRoles) {  // Si no tiene roles, se le asigna el rol de usuario
                try {
                    // Obtener el ID del rol de 'Usuario'
                    $roleId = $rbac->Roles->titleID('Usuario');
                    // Asignar rol por defecto
                    $rbac->Users->assign($roleId, $idUsuario['idusuario']);
                    // Establecer el ID de usuario en la sesión
                    session()->set('idusuario', $idUsuario['idusuario']);
                    // Mensaje de éxito
                    session()->setFlashdata('notification', 'Rol asignado con éxito al usuario: ' . $correo);
                } catch (\Exception $e) {
                    session()->setFlashdata('error', 'Hubo un error al asignar el rol al usuario.');
                    log_message('error', 'Error al asignar rol: ' . $e->getMessage());
                    return redirect()->to('/error')->with('message', 'There was an error with assing role');
                }
            } else {
                // Si el usuario ya tiene roles asignados
                session()->set('idusuario', $idUsuario['idusuario']);
                session()->setFlashdata('info', 'El correo ya está registrado y tiene roles asignados.');
            }
        } else {
            // Si no se encuentra el usuario con el correo proporcionado
            session()->setFlashdata('error', 'No se encontró el usuario con el correo proporcionado.');
        }
    }

    // Metodo para asignar roles a nuevos usuarios
    private function assignNewUserRole(UserModel $userModel, array $data)
    {
        $userRoles = new UserRolesModel();
        // Extract the domain from the email
        $emailParts = explode('@', $data['correo']);
        $domain = strtolower($emailParts[1]);
        // Dominos permitidos
        $organizationDomain = [
            'atlos56.onmicrosoft.com' => 'employee',
            'external.com' => 'external'
        ];
        // Verifica el dominio y asigna el rol correspondiente
        if (isset($organizationDomain[$domain])) {
            $userModel->insertData($data); /// 1.- Se insertan los datos de ESTUDIANTE NUEVO en la BD
            $idUsuario = $userModel->insertID(); /// 2.- Se obtiene el ID del ESTUDIANTE insertado
            // Si el correo es un ESTUDIANTE se le asigna el rol de Usuario
            if ($domain == 'atlos56.onmicrosoft.com') {
                $userRoles->setRoleToUser(2, $idUsuario); /// Rol 2: Estudiante
            } else {
                // Asignar rol por defecto en caso de ser externo
                $userRoles->setRoleToUser(1, $idUsuario); /// Rol 1: Externo
            }
            session()->set('idusuario', $idUsuario['idusuario']); /// 3.- Se almacena el ID del usuario en la sesion
        }
        // Set flash data message with inserted data
        session()->setFlashdata('notification', 'User  added: ' . $data['nombre'] . ' ' . $data['apellido1'] . ' (' . $data['correo'] . ')');
    }
}
