<?php
/**
 * Pembayaran Model
 * 
 * Model untuk mengelola data pembayaran
 * 
 * @author SIPKOS Team
 */

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    /**
     * Get pembayaran berdasarkan status
     */
    public function getByStatus($status)
    {
        return $this->getWhere(['status' => $status]);
    }

    /**
     * Get pembayaran penghuni tertentu
     */
    public function getByPenghuni($id_penghuni, $limit = null, $offset = 0)
    {
        $result = $this->getWhere(['id_penghuni' => $id_penghuni]);
        return $result;
    }

    /**
     * Get pembayaran dengan detail penghuni
     */
    public function getPembayaranWithDetail($limit = null, $offset = 0)
    {
        $query = "SELECT pb.*, p.nama as nama_penghuni, k.nomor_kamar
                  FROM " . $this->table . " pb
                  JOIN penghuni p ON pb.id_penghuni = p.id_penghuni
                  JOIN kamar k ON p.id_kamar = k.id_kamar
                  ORDER BY pb.created_at DESC";
        
        if (!is_null($limit)) {
            $query .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        }

        return $this->rawQuery($query);
    }

    /**
     * Get pembayaran bulan tertentu
     */
    public function getByMonth($month, $year)
    {
        $where = [
            'bulan' => $month,
            'tahun' => $year
        ];
        return $this->getWhere($where);
    }

    /**
     * Count pembayaran lunas bulan ini
     */
    public function countLunasThisMonth()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . "
                  WHERE status = 'lunas' 
                  AND MONTH(tanggal_bayar) = MONTH(CURDATE())
                  AND YEAR(tanggal_bayar) = YEAR(CURDATE())";
        
        $result = $this->rawQuery($query);
        return $result[0]['total'] ?? 0;
    }

    /**
     * Get total pembayaran bulan ini
     */
    public function getTotalPembayaranThisMonth()
    {
        $query = "SELECT SUM(total_bayar) as total FROM " . $this->table . "
                  WHERE status = 'lunas'
                  AND MONTH(tanggal_bayar) = MONTH(CURDATE())
                  AND YEAR(tanggal_bayar) = YEAR(CURDATE())";
        
        $result = $this->rawQuery($query);
        return $result[0]['total'] ?? 0;
    }

    /**
     * Check pembayaran sudah ada untuk periode tertentu
     */
    public function checkExists($id_penghuni, $bulan, $tahun)
    {
        $where = [
            'id_penghuni' => $id_penghuni,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
        return $this->exists($where);
    }
}

?>
