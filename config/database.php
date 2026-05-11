<?php
/**
 * SIPKOS - Database Configuration
 * 
 * File ini mengatur koneksi ke database MySQL menggunakan PDO
 * Implementasi OOP dengan singleton pattern untuk database connection
 * 
 * @author SIPKOS Team
 * @version 1.0
 */

class Database
{
    // Konfigurasi database
    private $host = 'localhost';
    private $db_name = 'sipkos_db';
    private $user = 'root';
    private $pass = '';
    private $port = '3306';
    private $charset = 'utf8mb4';

    // PDO connection
    private $conn;

    /**
     * Connect to database
     * 
     * @return PDO
     */
    public function connect()
    {
        $this->conn = null;

        try {
            // DSN (Data Source Name)
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . 
                   ";dbname=" . $this->db_name . ";charset=" . $this->charset;

            // PDO options
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => false
            ];

            // Create PDO instance
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);

            return $this->conn;
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    /**
     * Get database connection
     * 
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connect();
    }
}
?>
