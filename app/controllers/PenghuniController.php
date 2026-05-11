<?php
/**
 * Penghuni Controller
 * 
 * Controller untuk dashboard penghuni
 * 
 * @author SIPKOS Team
 */

class PenghuniController extends Controller
{
    /**
     * Check if user is penghuni
     */
    private function checkPenghuni()
    {
        if (!$this->isLoggedIn()) {
            $this->setFlash('error', 'Anda harus login terlebih dahulu');
            $this->redirect('login');
        }

        if ($this->isAdmin()) {
            $this->redirect('admin');
        }
    }

    /**
     * Dashboard penghuni
     */
    public function dashboard()
    {
        $this->checkPenghuni();

        require_once APP . 'models/Penghuni.php';
        require_once APP . 'models/Pembayaran.php';

        $penghuni_model = new Penghuni();
        $pembayaran_model = new Pembayaran();

        // Get penghuni data
        $penghuni = $penghuni_model->findByUserId($_SESSION['user_id']);

        if (!$penghuni) {
            $this->redirect('login');
        }

        // Get pembayaran history
        $pembayaran = $pembayaran_model->getByPenghuni($penghuni['id_penghuni']);

        // Get statistics
        $stats = [
            'kamar' => $penghuni['nomor_kamar'] ?? 'N/A',
            'status' => $penghuni['status'],
            'tanggal_masuk' => $penghuni['tanggal_masuk'],
            'total_pembayaran' => count($pembayaran),
            'pembayaran_lunas' => count(array_filter($pembayaran, fn($p) => $p['status'] === 'lunas')),
            'pembayaran_pending' => count(array_filter($pembayaran, fn($p) => $p['status'] === 'pending'))
        ];

        $this->view('penghuni/dashboard', [
            'title' => 'Dashboard Penghuni - SIPKOS',
            'penghuni' => $penghuni,
            'stats' => $stats,
            'pembayaran' => $pembayaran
        ]);
    }

    /**
     * Profil penghuni
     */
    public function profil()
    {
        $this->checkPenghuni();

        require_once APP . 'models/Penghuni.php';
        require_once APP . 'models/Kamar.php';

        $penghuni_model = new Penghuni();
        $kamar_model = new Kamar();

        $penghuni = $penghuni_model->findByUserId($_SESSION['user_id']);

        if (!$penghuni) {
            $this->redirect('login');
        }

        // Get kamar info
        $kamar = $kamar_model->getById($penghuni['id_kamar'], 'id_kamar');

        $this->view('penghuni/profil', [
            'title' => 'Profil - SIPKOS',
            'penghuni' => $penghuni,
            'kamar' => $kamar
        ]);
    }

    /**
     * Update profil
     */
    public function profilUpdate()
    {
        $this->checkPenghuni();

        if (!$this->isPost()) {
            $this->redirect('penghuni/profil');
        }

        require_once APP . 'models/Penghuni.php';
        $penghuni_model = new Penghuni();

        $penghuni = $penghuni_model->findByUserId($_SESSION['user_id']);

        if (!$penghuni) {
            $this->redirect('login');
        }

        // Update penghuni data
        $result = $penghuni_model->update([
            'nomor_hp' => $this->post('nomor_hp'),
            'alamat_asal' => $this->post('alamat_asal')
        ], ['id_penghuni' => $penghuni['id_penghuni']]);

        if ($result) {
            $this->setFlash('success', 'Profil berhasil diupdate');
        } else {
            $this->setFlash('error', 'Gagal update profil');
        }

        $this->redirect('penghuni/profil');
    }

    /**
     * Lihat riwayat pembayaran
     */
    public function pembayaran()
    {
        $this->checkPenghuni();

        require_once APP . 'models/Penghuni.php';
        require_once APP . 'models/Pembayaran.php';

        $penghuni_model = new Penghuni();
        $pembayaran_model = new Pembayaran();

        $penghuni = $penghuni_model->findByUserId($_SESSION['user_id']);

        if (!$penghuni) {
            $this->redirect('login');
        }

        // Get pembayaran history
        $pembayaran = $pembayaran_model->getByPenghuni($penghuni['id_penghuni']);

        $this->view('penghuni/pembayaran', [
            'title' => 'Riwayat Pembayaran - SIPKOS',
            'pembayaran' => $pembayaran,
            'penghuni' => $penghuni
        ]);
    }
}

?>
