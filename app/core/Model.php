<?php
/**
 * Base Model Class
 * 
 * Kelas dasar untuk semua model dengan method-method umum untuk query database
 * Implementasi OOP dengan reusable methods untuk CRUD operations
 * 
 * @author SIPKOS Team
 * @version 1.0
 */

class Model
{
    // Protected properties - dapat diakses oleh child class
    protected $db;
    protected $table;
    protected $columns = [];
    protected $last_error;

    /**
     * Constructor - initialize database connection
     */
    public function __construct()
    {
        // Inisialisasi database connection
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Ambil semua data dari tabel
     * 
     * @param int $limit - jumlah data yang diambil
     * @param int $offset - posisi awal data
     * @return array
     */
    public function getAll($limit = null, $offset = 0)
    {
        try {
            $query = "SELECT * FROM " . $this->table;

            if (!is_null($limit)) {
                $query .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
            }

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            return [];
        }
    }

    /**
     * Cari data berdasarkan ID
     * 
     * @param int $id
     * @param string $id_column - nama kolom primary key (default: id)
     * @return array|null
     */
    public function getById($id, $id_column = 'id')
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE " . $id_column . " = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            return null;
        }
    }

    /**
     * Cari data berdasarkan kondisi tertentu
     * 
     * @param array $where - array dengan key=column, value=value
     * @return array
     */
    public function getWhere($where = [])
    {
        try {
            $query = "SELECT * FROM " . $this->table;

            if (!empty($where)) {
                $conditions = [];
                $values = [];

                foreach ($where as $column => $value) {
                    $conditions[] = $column . " = ?";
                    $values[] = $value;
                }

                $query .= " WHERE " . implode(" AND ", $conditions);
                $stmt = $this->db->prepare($query);
                $stmt->execute($values);
            } else {
                $stmt = $this->db->prepare($query);
                $stmt->execute();
            }

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            return [];
        }
    }

    /**
     * Insert data ke database
     * 
     * @param array $data - array dengan key=column, value=value
     * @return int|false - return id terakhir atau false jika gagal
     */
    public function insert($data = [])
    {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), "?"));

            $query = "INSERT INTO " . $this->table . " (" . $columns . ") VALUES (" . $placeholders . ")";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array_values($data));

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            return false;
        }
    }

    /**
     * Update data di database
     * 
     * @param array $data - array dengan key=column, value=value
     * @param array $where - array kondisi where
     * @return bool
     */
    public function update($data = [], $where = [])
    {
        try {
            $set_clauses = [];
            $values = [];

            // Build SET clause
            foreach ($data as $column => $value) {
                $set_clauses[] = $column . " = ?";
                $values[] = $value;
            }

            // Build WHERE clause
            $where_clauses = [];
            foreach ($where as $column => $value) {
                $where_clauses[] = $column . " = ?";
                $values[] = $value;
            }

            $query = "UPDATE " . $this->table . " SET " . implode(", ", $set_clauses);
            if (!empty($where_clauses)) {
                $query .= " WHERE " . implode(" AND ", $where_clauses);
            }

            $stmt = $this->db->prepare($query);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            return false;
        }
    }

    /**
     * Delete data dari database
     * 
     * @param array $where - array kondisi where
     * @return bool
     */
    public function delete($where = [])
    {
        try {
            $where_clauses = [];
            $values = [];

            foreach ($where as $column => $value) {
                $where_clauses[] = $column . " = ?";
                $values[] = $value;
            }

            $query = "DELETE FROM " . $this->table;
            if (!empty($where_clauses)) {
                $query .= " WHERE " . implode(" AND ", $where_clauses);
            }

            $stmt = $this->db->prepare($query);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            return false;
        }
    }

    /**
     * Hitung jumlah data
     * 
     * @param array $where - array kondisi where (optional)
     * @return int
     */
    public function count($where = [])
    {
        try {
            $query = "SELECT COUNT(*) as total FROM " . $this->table;

            if (!empty($where)) {
                $conditions = [];
                $values = [];

                foreach ($where as $column => $value) {
                    $conditions[] = $column . " = ?";
                    $values[] = $value;
                }

                $query .= " WHERE " . implode(" AND ", $conditions);
                $stmt = $this->db->prepare($query);
                $stmt->execute($values);
            } else {
                $stmt = $this->db->prepare($query);
                $stmt->execute();
            }

            $result = $stmt->fetch();
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            return 0;
        }
    }

    /**
     * Eksekusi raw query
     * 
     * @param string $query
     * @param array $params
     * @return array
     */
    public function rawQuery($query, $params = [])
    {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->last_error = $e->getMessage();
            return [];
        }
    }

    /**
     * Get last error
     * 
     * @return string
     */
    public function getLastError()
    {
        return $this->last_error;
    }

    /**
     * Check if record exists
     * 
     * @param array $where
     * @return bool
     */
    public function exists($where = [])
    {
        return $this->count($where) > 0;
    }
}
?>
