<?php
/**
 * User Model
 * 
 * Model untuk mengelola data user
 * Extends dari base Model class
 * 
 * @author SIPKOS Team
 */

class User extends Model
{
    // Tentukan tabel yang digunakan
    protected $table = 'users';

    /**
     * Cari user berdasarkan email
     * 
     * @param string $email
     * @return array|null
     */
    public function findByEmail($email)
    {
        $result = $this->getWhere(['email' => $email]);
        return !empty($result) ? $result[0] : null;
    }

    /**
     * Cari user berdasarkan username
     * 
     * @param string $username
     * @return array|null
     */
    public function findByUsername($username)
    {
        $result = $this->getWhere(['username' => $username]);
        return !empty($result) ? $result[0] : null;
    }

    /**
     * Find user by email or username
     * 
     * @param string $identifier
     * @return array|null
     */
    public function findByEmailOrUsername($identifier)
    {
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = $this->findByEmail($identifier);
            if ($user) {
                return $user;
            }
        }

        return $this->findByUsername($identifier);
    }

    /**
     * Register user baru
     * 
     * @param array $data
     * @return int|false
     */
    public function register($data)
    {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Set role default ke penghuni
        if (!isset($data['role'])) {
            $data['role'] = 'penghuni';
        }

        return $this->insert($data);
    }

    /**
     * Verify password
     * 
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Cek email sudah terdaftar
     * 
     * @param string $email
     * @return bool
     */
    public function emailExists($email)
    {
        return $this->exists(['email' => $email]);
    }

    /**
     * Cek username sudah terdaftar
     * 
     * @param string $username
     * @return bool
     */
    public function usernameExists($username)
    {
        return $this->exists(['username' => $username]);
    }

    /**
     * Get user dengan role tertentu
     * 
     * @param string $role
     * @return array
     */
    public function getByRole($role)
    {
        return $this->getWhere(['role' => $role]);
    }
}

?>
