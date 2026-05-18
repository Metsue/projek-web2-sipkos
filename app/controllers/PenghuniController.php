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
        require_once APP . 'models/Kamar.php';

        $penghuni_model = new Penghuni();
        $pembayaran_model = new Pembayaran();
        $kamar_model = new Kamar();

        // Get penghuni data
        $penghuni = $penghuni_model->findByUserId($_SESSION['user_id']);

        if (!$penghuni) {
            $this->redirect('penghuni/profil/create');
            return;
        }

        // Get pembayaran history
        $pembayaran = $pembayaran_model->getByPenghuni($penghuni['id_penghuni']);

        // Get available rooms for dashboard listing
        $available_rooms = $kamar_model->getAvailable();

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
            'pembayaran' => $pembayaran,
            'available_rooms' => $available_rooms
        ]);
    }

    public function createProfile()
    {
        $this->checkPenghuni();

        require_once APP . 'models/Kamar.php';

        $kamar_model = new Kamar();
        $available_rooms = $kamar_model->getAvailable();

        $this->view('penghuni/create_profile', [
            'title' => 'Lengkapi Profil - SIPKOS',
            'available_rooms' => $available_rooms,
            'flash' => $this->getFlash()
        ]);
    }

    public function storeProfile()
    {
        $this->checkPenghuni();

        if (!$this->isPost()) {
            $this->redirect('penghuni/profil/create');
        }

        $nomor_hp = $this->post('nomor_hp');
        $alamat_asal = $this->post('alamat_asal');
        $id_kamar = $this->post('id_kamar');

        if (empty($nomor_hp) || empty($alamat_asal) || empty($id_kamar)) {
            $this->setFlash('error', 'Semua field wajib diisi');
            $this->redirect('penghuni/profil/create');
        }

        require_once APP . 'models/Penghuni.php';
        require_once APP . 'models/Kamar.php';

        $penghuni_model = new Penghuni();
        $kamar_model = new Kamar();

        $kamar = $kamar_model->getWhere(['id_kamar' => $id_kamar]);
        $kamar = !empty($kamar) ? $kamar[0] : null;

        if (!$kamar || $kamar['status'] !== 'tersedia') {
            $this->setFlash('error', 'Kamar tidak tersedia. Silakan pilih kamar lain.');
            $this->redirect('penghuni/profil/create');
        }

        $user = $_SESSION['user'];

        $result = $penghuni_model->insert([
            'nama' => $user['nama'],
            'email' => $user['email'],
            'nomor_hp' => $nomor_hp,
            'alamat_asal' => $alamat_asal,
            'tanggal_masuk' => date('Y-m-d'),
            'id_kamar' => $id_kamar,
            'user_id' => $_SESSION['user_id'],
            'status' => 'aktif'
        ]);

        if ($result) {
            $kamar_model->update(['status' => 'terisi'], ['id_kamar' => $id_kamar]);
            $this->setFlash('success', 'Profil berhasil dibuat. Selamat datang di dashboard!');
            $this->redirect('penghuni/dashboard');
        }

        $this->setFlash('error', 'Gagal menyimpan profil. Silakan coba lagi.');
        $this->redirect('penghuni/profil/create');
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
            $this->view('penghuni/missing_profile', [
                'title' => 'Akun Penghuni Belum Lengkap - SIPKOS'
            ]);
            return;
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
            $this->view('penghuni/missing_profile', [
                'title' => 'Akun Penghuni Belum Lengkap - SIPKOS'
            ]);
            return;
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
            $this->view('penghuni/missing_profile', [
                'title' => 'Akun Penghuni Belum Lengkap - SIPKOS'
            ]);
            return;
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
