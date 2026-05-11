<?php
/**
 * Kamar Model
 * 
 * Model untuk mengelola data kamar
 * 
 * @author SIPKOS Team
 */

class Kamar extends Model
{
    protected $table = 'kamar';

    /**
     * Get kamar berdasarkan status
     */
    public function getByStatus($status)
    {
        return $this->getWhere(['status' => $status]);
    }

    /**
     * Get kamar berdasarkan tipe
     */
    public function getByType($tipe)
    {
        return $this->getWhere(['tipe_kamar' => $tipe]);
    }

    /**
     * Cari kamar berdasarkan nomor
     */
    public function findByNomor($nomor)
    {
        $result = $this->getWhere(['nomor_kamar' => $nomor]);
        return !empty($result) ? $result[0] : null;
    }

    /**
     * Get kamar kosong
     */
    public function getAvailable()
    {
        return $this->getWhere(['status' => 'tersedia']);
    }

    /**
     * Get kamar terisi
     */
    public function getOccupied()
    {
        return $this->getWhere(['status' => 'terisi']);
    }

    /**
     * Count total kamar
     */
    public function countTotal()
    {
        return $this->count();
    }

    /**
     * Count kamar kosong
     */
    public function countAvailable()
    {
        return $this->count(['status' => 'tersedia']);
    }

    /**
     * Count kamar terisi
     */
    public function countOccupied()
    {
        return $this->count(['status' => 'terisi']);
    }
}

?>
