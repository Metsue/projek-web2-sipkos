<?php
/**
 * Auth Controller
 * 
 * Controller untuk mengelola authentication (login, register, logout)
 * 
 * @author SIPKOS Team
 */

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function login()
    {
        // Redirect jika sudah login
        if ($this->isLoggedIn()) {
            if ($this->isAdmin()) {
                $this->redirect('admin');
            } else {
                $this->redirect('penghuni/dashboard');
            }
        }

        $flash = $this->getFlash();

        $this->view('auth/login', [
            'title' => 'Login - SIPKOS',
            'flash' => $flash
        ]);
    }

    /**
     * Process login
     */
    public function processLogin()
    {
        if (!$this->isPost()) {
            $this->redirect('login');
        }

        // Get POST data
        $identifier = $this->post('identifier');
        $password = $this->post('password');

        // Validate input
        $errors = $this->validate([
            'identifier' => ['required', 'min:3'],
            'password' => ['required', 'min:6']
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Email/username atau password tidak valid');
            $this->redirect('login');
        }

        // Load user model
        require_once APP . 'models/User.php';
        $user_model = new User();

        // Find user by email or username
        $user = $user_model->findByEmailOrUsername($identifier);

        if (!$user) {
            $this->setFlash('error', 'User tidak ditemukan');
            $this->redirect('login');
        }

        // Verify password
        if (!$user_model->verifyPassword($password, $user['password'])) {
            $this->setFlash('error', 'Password salah');
            $this->redirect('login');
        }

        // Set session
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user'] = $user;

        // Log activity
        $this->logActivity('LOGIN', 'users', $user['id_user']);

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            $this->redirect('admin');
        } else {
            $this->redirect('penghuni/dashboard');
        }
    }

    /**
     * Show register form
     */
    public function register()
    {
        // Redirect jika sudah login
        if ($this->isLoggedIn()) {
            if ($this->isAdmin()) {
                $this->redirect('admin');
            }
            $this->redirect('penghuni/dashboard');
        }

        $flash = $this->getFlash();

        $this->view('auth/register', [
            'title' => 'Register - SIPKOS',
            'flash' => $flash
        ]);
    }

    /**
     * Process register
     */
    public function processRegister()
    {
        if (!$this->isPost()) {
            $this->redirect('register');
        }

        // Get POST data
        $nama = $this->post('nama');
        $email = $this->post('email');
        $username = $this->post('username');
        $password = $this->post('password');
        $password_confirm = $this->post('password_confirm');

        // Validate input
        $errors = $this->validate([
            'nama' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'username' => ['required', 'min:3'],
            'password' => ['required', 'min:6'],
            'password_confirm' => ['required']
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Validasi gagal, silahkan periksa input anda');
            $this->redirect('register');
        }

        // Check password match
        if ($password !== $password_confirm) {
            $this->setFlash('error', 'Password tidak cocok');
            $this->redirect('register');
        }

        // Load user model
        require_once APP . 'models/User.php';
        $user_model = new User();

        // Check email already exists
        if ($user_model->emailExists($email)) {
            $this->setFlash('error', 'Email sudah terdaftar');
            $this->redirect('register');
        }

        // Check username already exists
        if ($user_model->usernameExists($username)) {
            $this->setFlash('error', 'Username sudah digunakan');
            $this->redirect('register');
        }

        // Register user
        $result = $user_model->register([
            'nama' => $nama,
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'role' => 'penghuni'
        ]);

        if (!$result) {
            $this->setFlash('error', 'Gagal mendaftar, silahkan coba lagi');
            $this->redirect('register');
        }

        // Auto-login after register
        $_SESSION['user_id'] = $result;
        $_SESSION['user'] = [
            'id_user' => $result,
            'nama' => $nama,
            'email' => $email,
            'username' => $username,
            'role' => 'penghuni'
        ];

        $this->logActivity('REGISTER', 'users', $result);
        $this->setFlash('success', 'Registrasi berhasil. Silahkan lengkapi profil Anda.');
        $this->redirect('penghuni/profil/create');
    }

    /**
     * Logout
     */
    public function logout()
    {
        // Log activity
        if (isset($_SESSION['user_id'])) {
            $this->logActivity('LOGOUT', 'users', $_SESSION['user_id']);
        }

        // Destroy session
        session_destroy();

        // Redirect to login
        $this->redirect('login');
    }
}

?>
