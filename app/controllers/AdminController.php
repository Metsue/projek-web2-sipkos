<?php
/**
 * Admin Controller
 * 
 * Controller untuk admin dashboard dan CRUD operations
 * 
 * @author SIPKOS Team
 */

class AdminController extends Controller
{
    /**
     * Check if user is admin
     */
    private function checkAdmin()
    {
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->setFlash('error', 'Anda tidak memiliki akses');
            $this->redirect('login');
        }
    }

    /**
     * DASHBOARD
     */
    public function dashboard()
    {
        $this->checkAdmin();

        require_once APP . 'models/Kamar.php';
        require_once APP . 'models/Penghuni.php';
        require_once APP . 'models/Pembayaran.php';

        $kamar_model = new Kamar();
        $penghuni_model = new Penghuni();
        $pembayaran_model = new Pembayaran();

        // Get statistics
        $stats = [
            'total_kamar' => $kamar_model->countTotal(),
            'kamar_kosong' => $kamar_model->countAvailable(),
            'kamar_terisi' => $kamar_model->countOccupied(),
            'total_penghuni' => $penghuni_model->countTotal(),
            'penghuni_aktif' => $penghuni_model->countActive(),
            'pembayaran_lunas_bulan_ini' => $pembayaran_model->countLunasThisMonth(),
            'total_pembayaran_bulan_ini' => $pembayaran_model->getTotalPembayaranThisMonth()
        ];

        // Get recent payments
        $pembayaran_terbaru = $pembayaran_model->getPembayaranWithDetail(5);

        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard - SIPKOS',
            'stats' => $stats,
            'pembayaran_terbaru' => $pembayaran_terbaru
        ]);
    }

    /**
     * ============ KAMAR MANAGEMENT ============
     */

    /**
     * Kamar list
     */
    public function kamarIndex()
    {
        $this->checkAdmin();

        require_once APP . 'models/Kamar.php';
        $kamar_model = new Kamar();

        // Get all kamar
        $kamar_list = $kamar_model->getAll();
        $flash = $this->getFlash();

        $this->view('admin/kamar/index', [
            'title' => 'Data Kamar - SIPKOS',
            'kamar_list' => $kamar_list,
            'flash' => $flash
        ]);
    }

    /**
     * Create kamar form
     */
    public function kamarCreate()
    {
        $this->checkAdmin();

        $this->view('admin/kamar/create', [
            'title' => 'Tambah Kamar - SIPKOS'
        ]);
    }

    /**
     * Store kamar
     */
    public function kamarStore()
    {
        $this->checkAdmin();

        if (!$this->isPost()) {
            $this->redirect('admin/kamar');
        }

        require_once APP . 'models/Kamar.php';
        $kamar_model = new Kamar();

        // Validate input
        $errors = $this->validate([
            'nomor_kamar' => ['required'],
            'tipe_kamar' => ['required'],
            'harga' => ['required', 'numeric'],
            'status' => ['required']
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Validasi gagal');
            $this->redirect('admin/kamar/create');
        }

        // Check nomor kamar already exists
        if ($kamar_model->findByNomor($this->post('nomor_kamar'))) {
            $this->setFlash('error', 'Nomor kamar sudah terdaftar');
            $this->redirect('admin/kamar/create');
        }

        // Handle file upload
        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            $foto = $this->uploadFoto($_FILES['foto']);
            if (!$foto) {
                $this->setFlash('error', 'Gagal upload foto');
                $this->redirect('admin/kamar/create');
            }
        }

        // Insert kamar
        $result = $kamar_model->insert([
            'nomor_kamar' => $this->post('nomor_kamar'),
            'tipe_kamar' => $this->post('tipe_kamar'),
            'harga' => $this->post('harga'),
            'status' => $this->post('status'),
            'fasilitas' => $this->post('fasilitas'),
            'deskripsi' => $this->post('deskripsi'),
            'foto' => $foto
        ]);

        if ($result) {
            $this->logActivity('CREATE', 'kamar', $result);
            $this->setFlash('success', 'Kamar berhasil ditambahkan');
        } else {
            $this->setFlash('error', 'Gagal menambahkan kamar');
        }

        $this->redirect('admin/kamar');
    }

    /**
     * Edit kamar form
     */
    public function kamarEdit()
    {
        $this->checkAdmin();

        require_once APP . 'models/Kamar.php';
        $kamar_model = new Kamar();

        $id = $this->get('id');
        $kamar = $kamar_model->getById($id, 'id_kamar');

        if (!$kamar) {
            $this->setFlash('error', 'Kamar tidak ditemukan');
            $this->redirect('admin/kamar');
        }

        $this->view('admin/kamar/edit', [
            'title' => 'Edit Kamar - SIPKOS',
            'kamar' => $kamar
        ]);
    }

    /**
     * Update kamar
     */
    public function kamarUpdate()
    {
        $this->checkAdmin();

        if (!$this->isPost()) {
            $this->redirect('admin/kamar');
        }

        require_once APP . 'models/Kamar.php';
        $kamar_model = new Kamar();

        $id = $this->post('id_kamar');

        // Validate input
        $errors = $this->validate([
            'nomor_kamar' => ['required'],
            'tipe_kamar' => ['required'],
            'harga' => ['required', 'numeric'],
            'status' => ['required']
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Validasi gagal');
            $this->redirect('admin/kamar/edit?id=' . $id);
        }

        // Get kamar
        $kamar = $kamar_model->getById($id, 'id_kamar');
        if (!$kamar) {
            $this->setFlash('error', 'Kamar tidak ditemukan');
            $this->redirect('admin/kamar');
        }

        // Handle file upload
        $foto = $kamar['foto'];
        if (!empty($_FILES['foto']['name'])) {
            // Delete old foto
            if ($foto && file_exists(UPLOADS . 'kamar/' . $foto)) {
                unlink(UPLOADS . 'kamar/' . $foto);
            }
            $foto = $this->uploadFoto($_FILES['foto']);
            if (!$foto) {
                $this->setFlash('error', 'Gagal upload foto');
                $this->redirect('admin/kamar/edit?id=' . $id);
            }
        }

        // Update kamar
        $result = $kamar_model->update([
            'nomor_kamar' => $this->post('nomor_kamar'),
            'tipe_kamar' => $this->post('tipe_kamar'),
            'harga' => $this->post('harga'),
            'status' => $this->post('status'),
            'fasilitas' => $this->post('fasilitas'),
            'deskripsi' => $this->post('deskripsi'),
            'foto' => $foto
        ], ['id_kamar' => $id]);

        if ($result) {
            $this->logActivity('UPDATE', 'kamar', $id);
            $this->setFlash('success', 'Kamar berhasil diupdate');
        } else {
            $this->setFlash('error', 'Gagal update kamar');
        }

        $this->redirect('admin/kamar');
    }

    /**
     * Delete kamar
     */
    public function kamarDelete()
    {
        $this->checkAdmin();

        require_once APP . 'models/Kamar.php';
        $kamar_model = new Kamar();

        $id = $this->get('id');
        $kamar = $kamar_model->getById($id, 'id_kamar');

        if (!$kamar) {
            $this->setFlash('error', 'Kamar tidak ditemukan');
            $this->redirect('admin/kamar');
        }

        // Delete photo
        if ($kamar['foto'] && file_exists(UPLOADS . 'kamar/' . $kamar['foto'])) {
            unlink(UPLOADS . 'kamar/' . $kamar['foto']);
        }

        // Delete kamar
        $result = $kamar_model->delete(['id_kamar' => $id]);

        if ($result) {
            $this->logActivity('DELETE', 'kamar', $id);
            $this->setFlash('success', 'Kamar berhasil dihapus');
        } else {
            $this->setFlash('error', 'Gagal hapus kamar');
        }

        $this->redirect('admin/kamar');
    }

    /**
     * Show kamar detail
     */
    public function kamarShow()
    {
        $this->checkAdmin();

        require_once APP . 'models/Kamar.php';
        $kamar_model = new Kamar();

        $id = $this->get('id');
        $kamar = $kamar_model->getById($id, 'id_kamar');

        if (!$kamar) {
            $this->setFlash('error', 'Kamar tidak ditemukan');
            $this->redirect('admin/kamar');
        }

        $this->view('admin/kamar/show', [
            'title' => 'Detail Kamar - SIPKOS',
            'kamar' => $kamar
        ]);
    }

    /**
     * ============ PENGHUNI MANAGEMENT ============
     */

    /**
     * Penghuni list
     */
    public function penghuniIndex()
    {
        $this->checkAdmin();

        require_once APP . 'models/Penghuni.php';
        $penghuni_model = new Penghuni();

        $penghuni_list = $penghuni_model->getPenghuniWithKamar();
        $flash = $this->getFlash();

        $this->view('admin/penghuni/index', [
            'title' => 'Data Penghuni - SIPKOS',
            'penghuni_list' => $penghuni_list,
            'flash' => $flash
        ]);
    }

    /**
     * Create penghuni form
     */
    public function penghuniCreate()
    {
        $this->checkAdmin();

        require_once APP . 'models/Kamar.php';
        $kamar_model = new Kamar();
        $kamar_list = $kamar_model->getAvailable();

        $this->view('admin/penghuni/create', [
            'title' => 'Tambah Penghuni - SIPKOS',
            'kamar_list' => $kamar_list
        ]);
    }

    /**
     * Store penghuni
     */
    public function penghuniStore()
    {
        $this->checkAdmin();

        if (!$this->isPost()) {
            $this->redirect('admin/penghuni');
        }

        require_once APP . 'models/Penghuni.php';
        require_once APP . 'models/User.php';
        require_once APP . 'models/Kamar.php';

        $penghuni_model = new Penghuni();
        $user_model = new User();
        $kamar_model = new Kamar();

        // Validate input
        $errors = $this->validate([
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'nomor_hp' => ['required'],
            'alamat_asal' => ['required'],
            'id_kamar' => ['required']
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Validasi gagal');
            $this->redirect('admin/penghuni/create');
        }

        // Check email unique
        if ($user_model->emailExists($this->post('email'))) {
            $this->setFlash('error', 'Email sudah terdaftar');
            $this->redirect('admin/penghuni/create');
        }

        // Create user first
        $user_result = $user_model->insert([
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'username' => strtolower(str_replace(' ', '_', $this->post('nama'))),
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'penghuni'
        ]);

        if (!$user_result) {
            $this->setFlash('error', 'Gagal membuat user');
            $this->redirect('admin/penghuni/create');
        }

        // Insert penghuni
        $result = $penghuni_model->insert([
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'nomor_hp' => $this->post('nomor_hp'),
            'alamat_asal' => $this->post('alamat_asal'),
            'tanggal_masuk' => $this->post('tanggal_masuk'),
            'id_kamar' => $this->post('id_kamar'),
            'user_id' => $user_result,
            'status' => 'aktif'
        ]);

        if ($result) {
            // Update kamar status
            $kamar_model->update(['status' => 'terisi'], ['id_kamar' => $this->post('id_kamar')]);
            
            $this->logActivity('CREATE', 'penghuni', $result);
            $this->setFlash('success', 'Penghuni berhasil ditambahkan. Password default: password123');
        } else {
            $this->setFlash('error', 'Gagal menambahkan penghuni');
        }

        $this->redirect('admin/penghuni');
    }

    /**
     * Edit penghuni form
     */
    public function penghuniEdit()
    {
        $this->checkAdmin();

        require_once APP . 'models/Penghuni.php';
        require_once APP . 'models/Kamar.php';

        $penghuni_model = new Penghuni();
        $kamar_model = new Kamar();

        $id = $this->get('id');
        $penghuni = $penghuni_model->getById($id, 'id_penghuni');

        if (!$penghuni) {
            $this->setFlash('error', 'Penghuni tidak ditemukan');
            $this->redirect('admin/penghuni');
        }

        $kamar_list = $kamar_model->getAll();

        $this->view('admin/penghuni/edit', [
            'title' => 'Edit Penghuni - SIPKOS',
            'penghuni' => $penghuni,
            'kamar_list' => $kamar_list
        ]);
    }

    /**
     * Update penghuni
     */
    public function penghuniUpdate()
    {
        $this->checkAdmin();

        if (!$this->isPost()) {
            $this->redirect('admin/penghuni');
        }

        require_once APP . 'models/Penghuni.php';
        $penghuni_model = new Penghuni();

        $id = $this->post('id_penghuni');

        // Validate input
        $errors = $this->validate([
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'nomor_hp' => ['required'],
            'alamat_asal' => ['required']
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Validasi gagal');
            $this->redirect('admin/penghuni/edit?id=' . $id);
        }

        // Update penghuni
        $result = $penghuni_model->update([
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'nomor_hp' => $this->post('nomor_hp'),
            'alamat_asal' => $this->post('alamat_asal'),
            'tanggal_masuk' => $this->post('tanggal_masuk'),
            'status' => $this->post('status')
        ], ['id_penghuni' => $id]);

        if ($result) {
            $this->logActivity('UPDATE', 'penghuni', $id);
            $this->setFlash('success', 'Penghuni berhasil diupdate');
        } else {
            $this->setFlash('error', 'Gagal update penghuni');
        }

        $this->redirect('admin/penghuni');
    }

    /**
     * Delete penghuni
     */
    public function penghuniDelete()
    {
        $this->checkAdmin();

        require_once APP . 'models/Penghuni.php';
        require_once APP . 'models/Kamar.php';

        $penghuni_model = new Penghuni();
        $kamar_model = new Kamar();

        $id = $this->get('id');
        $penghuni = $penghuni_model->getById($id, 'id_penghuni');

        if (!$penghuni) {
            $this->setFlash('error', 'Penghuni tidak ditemukan');
            $this->redirect('admin/penghuni');
        }

        // Update kamar status to available
        $kamar_model->update(['status' => 'tersedia'], ['id_kamar' => $penghuni['id_kamar']]);

        // Delete penghuni
        $result = $penghuni_model->delete(['id_penghuni' => $id]);

        if ($result) {
            $this->logActivity('DELETE', 'penghuni', $id);
            $this->setFlash('success', 'Penghuni berhasil dihapus');
        } else {
            $this->setFlash('error', 'Gagal hapus penghuni');
        }

        $this->redirect('admin/penghuni');
    }

    /**
     * Show penghuni detail
     */
    public function penghuniShow()
    {
        $this->checkAdmin();

        require_once APP . 'models/Penghuni.php';
        require_once APP . 'models/Pembayaran.php';

        $penghuni_model = new Penghuni();
        $pembayaran_model = new Pembayaran();

        $id = $this->get('id');
        $penghuni = $penghuni_model->getById($id, 'id_penghuni');

        if (!$penghuni) {
            $this->setFlash('error', 'Penghuni tidak ditemukan');
            $this->redirect('admin/penghuni');
        }

        // Get pembayaran history
        $pembayaran = $pembayaran_model->getByPenghuni($id);

        $this->view('admin/penghuni/show', [
            'title' => 'Detail Penghuni - SIPKOS',
            'penghuni' => $penghuni,
            'pembayaran' => $pembayaran
        ]);
    }

    /**
     * ============ PEMBAYARAN MANAGEMENT ============
     */

    /**
     * Pembayaran list
     */
    public function pembayaranIndex()
    {
        $this->checkAdmin();

        require_once APP . 'models/Pembayaran.php';
        $pembayaran_model = new Pembayaran();

        $pembayaran_list = $pembayaran_model->getPembayaranWithDetail();
        $flash = $this->getFlash();

        $this->view('admin/pembayaran/index', [
            'title' => 'Data Pembayaran - SIPKOS',
            'pembayaran_list' => $pembayaran_list,
            'flash' => $flash
        ]);
    }

    /**
     * Create pembayaran form
     */
    public function pembayaranCreate()
    {
        $this->checkAdmin();

        require_once APP . 'models/Penghuni.php';
        $penghuni_model = new Penghuni();
        $penghuni_list = $penghuni_model->getActive();

        $this->view('admin/pembayaran/create', [
            'title' => 'Catat Pembayaran - SIPKOS',
            'penghuni_list' => $penghuni_list
        ]);
    }

    /**
     * Store pembayaran
     */
    public function pembayaranStore()
    {
        $this->checkAdmin();

        if (!$this->isPost()) {
            $this->redirect('admin/pembayaran');
        }

        require_once APP . 'models/Pembayaran.php';
        $pembayaran_model = new Pembayaran();

        // Validate input
        $errors = $this->validate([
            'id_penghuni' => ['required'],
            'bulan' => ['required'],
            'tahun' => ['required'],
            'total_bayar' => ['required', 'numeric'],
            'status' => ['required']
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Validasi gagal');
            $this->redirect('admin/pembayaran/create');
        }

        // Check pembayaran already exists
        if ($pembayaran_model->checkExists($this->post('id_penghuni'), $this->post('bulan'), $this->post('tahun'))) {
            $this->setFlash('error', 'Pembayaran sudah tercatat untuk periode ini');
            $this->redirect('admin/pembayaran/create');
        }

        // Insert pembayaran
        $data = [
            'id_penghuni' => $this->post('id_penghuni'),
            'bulan' => $this->post('bulan'),
            'tahun' => $this->post('tahun'),
            'total_bayar' => $this->post('total_bayar'),
            'status' => $this->post('status'),
            'keterangan' => $this->post('keterangan')
        ];

        if ($this->post('status') === 'lunas') {
            $data['tanggal_bayar'] = date('Y-m-d');
        }

        $result = $pembayaran_model->insert($data);

        if ($result) {
            $this->logActivity('CREATE', 'pembayaran', $result);
            $this->setFlash('success', 'Pembayaran berhasil dicatat');
        } else {
            $this->setFlash('error', 'Gagal mencatat pembayaran');
        }

        $this->redirect('admin/pembayaran');
    }

    /**
     * Edit pembayaran form
     */
    public function pembayaranEdit()
    {
        $this->checkAdmin();

        require_once APP . 'models/Pembayaran.php';
        require_once APP . 'models/Penghuni.php';

        $pembayaran_model = new Pembayaran();
        $penghuni_model = new Penghuni();

        $id = $this->get('id');
        $pembayaran = $pembayaran_model->getById($id, 'id_pembayaran');

        if (!$pembayaran) {
            $this->setFlash('error', 'Pembayaran tidak ditemukan');
            $this->redirect('admin/pembayaran');
        }

        $penghuni_list = $penghuni_model->getActive();

        $this->view('admin/pembayaran/edit', [
            'title' => 'Edit Pembayaran - SIPKOS',
            'pembayaran' => $pembayaran,
            'penghuni_list' => $penghuni_list
        ]);
    }

    /**
     * Update pembayaran
     */
    public function pembayaranUpdate()
    {
        $this->checkAdmin();

        if (!$this->isPost()) {
            $this->redirect('admin/pembayaran');
        }

        require_once APP . 'models/Pembayaran.php';
        $pembayaran_model = new Pembayaran();

        $id = $this->post('id_pembayaran');

        // Update pembayaran
        $data = [
            'total_bayar' => $this->post('total_bayar'),
            'status' => $this->post('status'),
            'keterangan' => $this->post('keterangan')
        ];

        if ($this->post('status') === 'lunas') {
            $data['tanggal_bayar'] = date('Y-m-d');
        }

        $result = $pembayaran_model->update($data, ['id_pembayaran' => $id]);

        if ($result) {
            $this->logActivity('UPDATE', 'pembayaran', $id);
            $this->setFlash('success', 'Pembayaran berhasil diupdate');
        } else {
            $this->setFlash('error', 'Gagal update pembayaran');
        }

        $this->redirect('admin/pembayaran');
    }

    /**
     * Delete pembayaran
     */
    public function pembayaranDelete()
    {
        $this->checkAdmin();

        require_once APP . 'models/Pembayaran.php';
        $pembayaran_model = new Pembayaran();

        $id = $this->get('id');
        $pembayaran = $pembayaran_model->getById($id, 'id_pembayaran');

        if (!$pembayaran) {
            $this->setFlash('error', 'Pembayaran tidak ditemukan');
            $this->redirect('admin/pembayaran');
        }

        // Delete pembayaran
        $result = $pembayaran_model->delete(['id_pembayaran' => $id]);

        if ($result) {
            $this->logActivity('DELETE', 'pembayaran', $id);
            $this->setFlash('success', 'Pembayaran berhasil dihapus');
        } else {
            $this->setFlash('error', 'Gagal hapus pembayaran');
        }

        $this->redirect('admin/pembayaran');
    }

    /**
     * ============ LAPORAN ============
     */

    /**
     * Laporan list
     */
    public function laporanIndex()
    {
        $this->checkAdmin();

        require_once APP . 'models/Pembayaran.php';
        $pembayaran_model = new Pembayaran();

        $filter_bulan = $this->get('bulan', date('m'));
        $filter_tahun = $this->get('tahun', date('Y'));

        $pembayaran_list = $pembayaran_model->getByMonth($filter_bulan, $filter_tahun);

        $this->view('admin/laporan/index', [
            'title' => 'Laporan Pembayaran - SIPKOS',
            'pembayaran_list' => $pembayaran_list,
            'filter_bulan' => $filter_bulan,
            'filter_tahun' => $filter_tahun
        ]);
    }

    /**
     * Export PDF
     */
    public function exportPDF()
    {
        $this->checkAdmin();

        if (!$this->isPost()) {
            $this->redirect('admin/laporan');
        }

        // TODO: Implement PDF export using FPDF library
        $this->setFlash('success', 'Export PDF sedang dikembangkan');
        $this->redirect('admin/laporan');
    }

    /**
     * Upload foto kamar
     */
    private function uploadFoto($file)
    {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        // Check file type
        if (!in_array($file['type'], $allowed_types)) {
            return false;
        }

        // Check file size
        if ($file['size'] > $max_size) {
            return false;
        }

        // Create upload directory if not exists
        $upload_dir = UPLOADS . 'kamar/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Generate unique filename
        $filename = time() . '_' . rand(1000, 9999) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $filepath = $upload_dir . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return $filename;
        }

        return false;
    }
}

?>
