<?php
namespace App\Controllers\OAuthlogin;

use CodeIgniter\Controller;
use League\OAuth2\Client\Provider\GenericProvider;
use Config\OAuth;

class OAuthController extends Controller
{
    protected $microsoftProvider;

    public function __construct()
    {
        // Carga el proveedor de Microsoft OAuth desde la configuracion
        $credentials = (new OAuth())->credentials;
        $this->microsoftProvider = new GenericProvider([
          //  'clientId'                => $credentials['clientId'],
          //  'clientSecret'            => $credentials['clientSecret'],
            //'tenantId'                => $credentials['tenantId'],  // Your Redirect URI
            'urlAuthorize'            => 'https://login.microsoftonline.com/' . $credentials['tenantId'] . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/' . $credentials['tenantId'] . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me', // Microsoft Graph API endpoint to fetch user info
            'scopes'                  => ['openid profile offline_access user.read'],
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

        // Ensure the code is present
        // Asegúrese de que el código está presente
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
            // Usa el token de acceso para obtener la informacion del usuaio
            $resourceOwner = $this->microsoftProvider->getResourceOwner($accessToken);

            // Get the user info (profile)
            $userData = $resourceOwner->toArray();  // Array containing user info

            // Store the access token and user information in session or database
            // Guarda el token de accedso y la informacion de usuario en la sesion o base de datos
            session()->set('access_token', $accessToken);
            session()->set('name', $userData);

            // Redirect the user to a secured page (e.g., dashboard)
            // Redirige al usuario a una pagina segura (e.g., dashboard)
            return redirect()->to('/dashboard');
        } catch (\Exception $e) {
            exit('Error fetching the access token: ' . $e->getMessage());
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

        $user = session()->get('name');
        return view('Layouts/principal', ['user' => $user]);
    }

    // Step 4: Logout and clear the session
    // Step 4: Cierra sesion y limpia la sesion
    public function logout()
    {
        session()->remove('name');
        session()->remove('access_token');
        return redirect()->to(base_url('/'));
    }
}
