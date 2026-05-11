<?php
/**
 * Base Controller Class
 * 
 * Kelas dasar untuk semua controller
 * Menyediakan method-method umum untuk render view, handle request, dll
 * 
 * @author SIPKOS Team
 * @version 1.0
 */

class Controller
{
    // Method untuk load view
    protected function view($view_path, $data = [])
    {
        // Extract data array menjadi variable individual
        extract($data);

        // Path ke file view
        $file_path = APP . 'views/' . $view_path . '.php';

        if (file_exists($file_path)) {
            include $file_path;
        } else {
            die("View not found: " . $view_path);
        }
    }

    // Method untuk redirect
    protected function redirect($url)
    {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    // Method untuk check if request is POST
    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Method untuk check if request is GET
    protected function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    // Method untuk ambil POST data
    protected function post($key = null, $default = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : $default;
    }

    // Method untuk ambil GET data
    protected function get($key = null, $default = null)
    {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? htmlspecialchars($_GET[$key]) : $default;
    }

    // Method untuk ambil REQUEST data
    protected function request($key = null, $default = null)
    {
        if ($key === null) {
            return array_merge($_GET, $_POST);
        }
        return isset($_REQUEST[$key]) ? htmlspecialchars($_REQUEST[$key]) : $default;
    }

    // Method untuk check session
    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    // Method untuk ambil user session
    protected function getUser()
    {
        return $_SESSION['user'] ?? null;
    }

    // Method untuk check user role
    protected function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    // Method untuk set session
    protected function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // Method untuk hapus session
    protected function unsetSession($key)
    {
        unset($_SESSION[$key]);
    }

    // Method untuk set flash message
    protected function setFlash($type, $message)
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    // Method untuk ambil flash message
    protected function getFlash()
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    // Method untuk response JSON
    protected function json($data, $status_code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status_code);
        echo json_encode($data);
        exit;
    }

    // Method untuk validate input
    protected function validate($rules = [])
    {
        $errors = [];

        foreach ($rules as $field => $field_rules) {
            $value = $this->post($field);

            foreach ($field_rules as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $errors[$field][] = "Field {$field} harus diisi";
                } elseif (strpos($rule, 'min:') === 0) {
                    $min = (int)substr($rule, 4);
                    if (strlen($value) < $min) {
                        $errors[$field][] = "Field {$field} minimal {$min} karakter";
                    }
                } elseif (strpos($rule, 'max:') === 0) {
                    $max = (int)substr($rule, 4);
                    if (strlen($value) > $max) {
                        $errors[$field][] = "Field {$field} maksimal {$max} karakter";
                    }
                } elseif ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = "Field {$field} harus email yang valid";
                } elseif ($rule === 'numeric' && !is_numeric($value)) {
                    $errors[$field][] = "Field {$field} harus angka";
                }
            }
        }

        return $errors;
    }

    // Method untuk log activity
    protected function logActivity($action, $table, $id_record, $detail = null)
    {
        // Buat model untuk logging
        require_once APP . 'models/LogActivity.php';
        $log = new LogActivity();
        
        $log->insert([
            'id_user' => $_SESSION['user_id'] ?? null,
            'aksi' => $action,
            'tabel' => $table,
            'id_record' => $id_record,
            'detail' => $detail
        ]);
    }
}
?>
