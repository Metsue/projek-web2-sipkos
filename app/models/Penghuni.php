<?php
/**
 * Penghuni Model
 * 
 * Model untuk mengelola data penghuni
 * 
 * @author SIPKOS Team
 */

class Penghuni extends Model
{
    protected $table = 'penghuni';

    /**
     * Get penghuni berdasarkan user_id
     */
    public function findByUserId($user_id)
    {
        $result = $this->getWhere(['user_id' => $user_id]);
        return !empty($result) ? $result[0] : null;
    }

    /**
     * Get penghuni berdasarkan kamar_id
     */
    public function findByKamarId($kamar_id)
    {
        $result = $this->getWhere(['id_kamar' => $kamar_id]);
        return !empty($result) ? $result[0] : null;
    }

    /**
     * Get penghuni aktif
     */
    public function getActive()
    {
        return $this->getWhere(['status' => 'aktif']);
    }

    /**
     * Get penghuni dengan detail kamar
     */
    public function getPenghuniWithKamar($limit = null, $offset = 0)
    {
        $query = "SELECT p.*, k.nomor_kamar, k.tipe_kamar, k.harga 
                  FROM " . $this->table . " p
                  JOIN kamar k ON p.id_kamar = k.id_kamar
                  ORDER BY p.id_penghuni DESC";
        
        if (!is_null($limit)) {
            $query .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        }

        return $this->rawQuery($query);
    }

    /**
     * Count total penghuni
     */
    public function countTotal()
    {
        return $this->count();
    }

    /**
     * Count penghuni aktif
     */
    public function countActive()
    {
        return $this->count(['status' => 'aktif']);
    }
}

?>
