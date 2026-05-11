<?php
/**
 * Page Controller
 * 
 * Controller untuk halaman-halaman publik
 * 
 * @author SIPKOS Team
 */

class PageController extends Controller
{
    /**
     * Homepage
     */
    public function index()
    {
        // Redirect ke login jika belum login
        if (!$this->isLoggedIn()) {
            $this->redirect('login');
        }

        // Redirect berdasarkan role
        if ($this->isAdmin()) {
            $this->redirect('admin');
        } else {
            $this->redirect('penghuni/dashboard');
        }
    }

    /**
     * Login page
     */
    public function login()
    {
        $flash = $this->getFlash();
        $this->view('auth/login', [
            'title' => 'Login - SIPKOS',
            'flash' => $flash
        ]);
    }

    /**
     * Register page
     */
    public function register()
    {
        $flash = $this->getFlash();
        $this->view('auth/register', [
            'title' => 'Register - SIPKOS',
            'flash' => $flash
        ]);
    }
}

?>
