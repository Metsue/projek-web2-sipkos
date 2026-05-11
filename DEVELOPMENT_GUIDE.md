# DEVELOPMENT GUIDE - SIPKOS

Panduan lengkap untuk mengembangkan fitur baru dan maintenance aplikasi SIPKOS.

---

## 📚 Table of Contents

1. [Development Workflow](#development-workflow)
2. [Menambah Fitur Baru](#menambah-fitur-baru)
3. [Struktur File yang Benar](#struktur-file-yang-benar)
4. [Code Standards](#code-standards)
5. [Testing](#testing)
6. [Debugging](#debugging)
7. [Performance Optimization](#performance-optimization)
8. [Deployment](#deployment)

---

## 🔄 Development Workflow

### 1. Planning
```
1. Definisikan requirements
2. Desain database schema
3. Buat list controller methods
4. List views yang diperlukan
```

### 2. Database Design
```
1. Identifikasi tabel baru/update
2. Buat ERD jika perlu
3. Tulis SQL schema
4. Test dengan dummy data
```

### 3. Backend Development
```
1. Buat Model
2. Buat Controller
3. Buat Routes
4. Test semua method
```

### 4. Frontend Development
```
1. Buat Views
2. Styling dengan CSS
3. Tambah JavaScript jika perlu
4. Test responsiveness
```

### 5. Integration Testing
```
1. Test end-to-end
2. Test edge cases
3. Test error handling
4. Performance test
```

### 6. Deployment
```
1. Code review
2. Testing di staging
3. Backup production
4. Deploy ke production
5. Monitor logs
```

---

## ✨ Menambah Fitur Baru

### Contoh: Menambah Fitur "Pesan Kamar"

#### STEP 1: Database Design

**File: config/sipkos_db.sql**
```sql
-- Tambahkan tabel pemesanan
CREATE TABLE IF NOT EXISTS pemesanan (
    id_pemesanan INT PRIMARY KEY AUTO_INCREMENT,
    id_penghuni INT NOT NULL,
    id_kamar INT NOT NULL,
    tanggal_pemesanan DATE NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'completed') DEFAULT 'pending',
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_penghuni) REFERENCES penghuni(id_penghuni),
    FOREIGN KEY (id_kamar) REFERENCES kamar(id_kamar),
    INDEX idx_status (status),
    INDEX idx_penghuni (id_penghuni)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Jalankan SQL:**
- Di phpMyAdmin atau command line

#### STEP 2: Buat Model

**File: app/models/Pemesanan.php**
```php
<?php
/**
 * Pemesanan Model
 * Model untuk mengelola data pemesanan kamar
 */

class Pemesanan extends Model {
    protected $table = 'pemesanan';

    /**
     * Get pemesanan pending
     */
    public function getPending() {
        return $this->getWhere(['status' => 'pending']);
    }

    /**
     * Get pemesanan by penghuni
     */
    public function getByPenghuni($id_penghuni) {
        return $this->getWhere(['id_penghuni' => $id_penghuni]);
    }

    /**
     * Get pemesanan by kamar
     */
    public function getByKamar($id_kamar) {
        return $this->getWhere(['id_kamar' => $id_kamar]);
    }

    /**
     * Check kamar available
     */
    public function isKamarAvailable($id_kamar, $tanggal_mulai, $tanggal_selesai) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . "
                  WHERE id_kamar = ? 
                  AND status IN ('pending', 'approved')
                  AND (
                    (tanggal_mulai <= ? AND tanggal_selesai >= ?)
                    OR (tanggal_mulai <= ? AND tanggal_selesai >= ?)
                  )";
        
        $result = $this->rawQuery($query, [
            $id_kamar, $tanggal_selesai, $tanggal_mulai,
            $tanggal_mulai, $tanggal_selesai
        ]);
        
        return ($result[0]['total'] ?? 0) == 0;
    }
}
?>
```

#### STEP 3: Buat Controller

**File: app/controllers/PemesananController.php**
```php
<?php
/**
 * Pemesanan Controller
 * Controller untuk mengelola pemesanan kamar
 */

class PemesananController extends Controller {
    
    /**
     * Pemesanan list
     */
    public function index() {
        if (!$this->isLoggedIn()) {
            $this->redirect('login');
        }

        require_once APP . 'models/Pemesanan.php';
        $pemesanan_model = new Pemesanan();

        if ($this->isAdmin()) {
            // Admin lihat semua pemesanan
            $list = $pemesanan_model->getAll();
            $title = 'Data Pemesanan';
        } else {
            // Penghuni lihat pemesanan sendiri
            $list = $pemesanan_model->getByPenghuni($_SESSION['user_id']);
            $title = 'Pemesanan Saya';
        }

        $this->view('pemesanan/index', [
            'title' => $title,
            'pemesanan_list' => $list
        ]);
    }

    /**
     * Create pemesanan
     */
    public function create() {
        if (!$this->isLoggedIn()) {
            $this->redirect('login');
        }

        require_once APP . 'models/Kamar.php';
        $kamar_model = new Kamar();
        $kamar_list = $kamar_model->getAvailable();

        $this->view('pemesanan/create', [
            'title' => 'Pesan Kamar',
            'kamar_list' => $kamar_list
        ]);
    }

    /**
     * Store pemesanan
     */
    public function store() {
        if (!$this->isPost()) {
            $this->redirect('pemesanan');
        }

        require_once APP . 'models/Pemesanan.php';
        $pemesanan_model = new Pemesanan();

        // Validate
        $errors = $this->validate([
            'id_kamar' => ['required'],
            'tanggal_mulai' => ['required'],
            'tanggal_selesai' => ['required']
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Validasi gagal');
            $this->redirect('pemesanan/create');
        }

        // Check ketersediaan kamar
        if (!$pemesanan_model->isKamarAvailable(
            $this->post('id_kamar'),
            $this->post('tanggal_mulai'),
            $this->post('tanggal_selesai')
        )) {
            $this->setFlash('error', 'Kamar tidak tersedia untuk periode ini');
            $this->redirect('pemesanan/create');
        }

        // Insert
        $result = $pemesanan_model->insert([
            'id_penghuni' => $_SESSION['user_id'],
            'id_kamar' => $this->post('id_kamar'),
            'tanggal_pemesanan' => date('Y-m-d'),
            'tanggal_mulai' => $this->post('tanggal_mulai'),
            'tanggal_selesai' => $this->post('tanggal_selesai'),
            'status' => 'pending',
            'catatan' => $this->post('catatan')
        ]);

        if ($result) {
            $this->setFlash('success', 'Pemesanan berhasil dibuat');
        } else {
            $this->setFlash('error', 'Gagal membuat pemesanan');
        }

        $this->redirect('pemesanan');
    }

    /**
     * Approve pemesanan (admin only)
     */
    public function approve() {
        if (!$this->isAdmin()) {
            $this->redirect('login');
        }

        require_once APP . 'models/Pemesanan.php';
        $pemesanan_model = new Pemesanan();

        $id = $this->get('id');
        $result = $pemesanan_model->update(
            ['status' => 'approved'],
            ['id_pemesanan' => $id]
        );

        if ($result) {
            $this->setFlash('success', 'Pemesanan disetujui');
        } else {
            $this->setFlash('error', 'Gagal approve pemesanan');
        }

        $this->redirect('pemesanan');
    }
}
?>
```

#### STEP 4: Tambahkan Routes

**File: routes/web.php** (tambahkan di akhir file)
```php
// Pemesanan Routes
$router->get('/pemesanan', 'pemesanan@index');
$router->get('/pemesanan/create', 'pemesanan@create');
$router->post('/pemesanan/store', 'pemesanan@store');
$router->get('/pemesanan/approve/:id', 'pemesanan@approve');
```

#### STEP 5: Buat Views

**File: app/views/pemesanan/index.php**
```html
<div class="row mb-4">
    <div class="col-md-8">
        <h2><?php echo htmlspecialchars($title); ?></h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo BASE_URL; ?>pemesanan/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Pesan Kamar
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($pemesanan_list)): ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kamar</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pemesanan_list as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nomor_kamar'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($item['tanggal_mulai']); ?></td>
                            <td><?php echo htmlspecialchars($item['tanggal_selesai']); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $item['status'] === 'approved' ? 'success' : 
                                         ($item['status'] === 'rejected' ? 'danger' : 'warning'); 
                                ?>">
                                    <?php echo ucfirst($item['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($this->isAdmin() && $item['status'] === 'pending'): ?>
                                    <a href="<?php echo BASE_URL; ?>pemesanan/approve?id=<?php echo $item['id_pemesanan']; ?>" 
                                       class="btn btn-sm btn-success">
                                        Approve
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted text-center">Tidak ada data</p>
        <?php endif; ?>
    </div>
</div>
```

#### STEP 6: Test

```
1. Buka http://localhost/projek-web2-sipkos/pemesanan
2. Klik "Pesan Kamar"
3. Isi form dan submit
4. Verifikasi data tersimpan di database
5. Admin approve pemesanan
6. Verifikasi status berubah
```

---

## 📐 Struktur File yang Benar

### Naming Convention

**Controllers:**
```
app/controllers/NamaController.php
class NamaController extends Controller { }

Convention:
- Nama class: PascalCase
- Nama file: PascalCase + Controller.php
- Method: camelCase
```

**Models:**
```
app/models/Nama.php
class Nama extends Model { }

Convention:
- Nama class: PascalCase (sesuai nama tabel)
- Nama file: PascalCase.php
- Method: camelCase
```

**Views:**
```
app/views/folder/nama.php

Convention:
- Folder: lowercase
- File: lowercase.php
- Path: lowercase/lowercase.php
```

**Routes:**
```
$router->method('/path', 'controller@method');

Convention:
- Path: /lowercase/lowercase (kebab-case)
- Controller: lowercase
- Method: camelCase
```

---

## 📝 Code Standards

### PHP Coding Style

```php
<?php
/**
 * Class Description
 * 
 * @author Developer Name
 * @version 1.0
 */

class MyClass {
    
    // Visibility (public/protected/private)
    private $property;
    protected $protected_property;
    public $public_property;
    
    /**
     * Method description
     * 
     * @param type $param Description
     * @return type Description
     */
    public function methodName($param) {
        // Logic here
        if ($condition) {
            return true;
        }
        
        return false;
    }
}
?>
```

### Best Practices

```php
// ❌ BAD
$x = $db->query("SELECT * FROM users WHERE id = " . $_GET['id']);

// ✅ GOOD
$user = new User();
$user = $user->getById($_GET['id']);
```

```php
// ❌ BAD
if ($user['role'] == 'admin') { }

// ✅ GOOD
if ($user['role'] === 'admin') { }
```

```php
// ❌ BAD
echo $_POST['name'];

// ✅ GOOD
echo htmlspecialchars($_POST['name']);
```

```php
// ❌ BAD
$conn = new mysqli("localhost", "root", "", "db");

// ✅ GOOD
$database = new Database();
$conn = $database->connect();
```

---

## 🧪 Testing

### Unit Testing Pattern

```php
// Test Model
class UserTest {
    public function testGetById() {
        $user = new User();
        $result = $user->getById(1);
        
        assert($result !== null);
        assert($result['id_user'] === 1);
    }
}
```

### Manual Testing Checklist

```
[ ] Form validation works
[ ] Input sanitization works
[ ] Database operation success
[ ] Error handling correct
[ ] Response correct
[ ] UI displays correct
[ ] Mobile responsive
```

---

## 🐛 Debugging

### Enable Debug Mode

```php
// index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');
```

### Debug Techniques

```php
// 1. var_dump
var_dump($variable);
die();

// 2. error_log
error_log('Message: ' . json_encode($data));

// 3. Debug bar
echo '<pre>'; print_r($data); echo '</pre>';

// 4. Browser console
console.log('Data:', data);
```

### Check Logs

```
Apache: C:\xampp\apache\logs\error.log
MySQL: C:\xampp\mysql\data\error.log
PHP: C:\xampp\php\logs\php_errors.log (if exists)
```

---

## ⚡ Performance Optimization

### Database Optimization

```php
// ❌ N+1 Query Problem
foreach ($users as $user) {
    $orders = Order::where('user_id', $user['id'])->get(); // Query each user
}

// ✅ JOIN Query
$query = "SELECT u.*, o.* FROM users u 
          LEFT JOIN orders o ON u.id = o.user_id";
```

### Caching

```php
// Simple caching
if (!isset($_SESSION['user_cache'])) {
    $_SESSION['user_cache'] = $user_model->getAll();
}
$users = $_SESSION['user_cache'];
```

### Pagination

```php
// Always use pagination for large data
$page = $this->get('page', 1);
$limit = 20;
$offset = ($page - 1) * $limit;

$users = $user_model->getAll($limit, $offset);
```

---

## 🚀 Deployment

### Pre-Deployment Checklist

```
[ ] All tests passed
[ ] No debug code in production
[ ] Database backed up
[ ] Error logging configured
[ ] Security reviewed
[ ] Performance tested
[ ] Documentation updated
[ ] Code reviewed
```

### Deployment Steps

```
1. Test di local
2. Test di staging
3. Backup production database
4. Deploy to production
5. Run migration scripts
6. Test in production
7. Monitor logs
8. Keep rollback ready
```

### Rollback Plan

```
1. Database restore from backup
2. Code revert to previous version
3. Test critical functions
4. Monitor system
```

---

## 📖 Additional Resources

- PHP Documentation: https://www.php.net/
- MySQL Documentation: https://dev.mysql.com/doc/
- OWASP Security: https://owasp.org/
- PSR Standards: https://www.php-fig.org/

---

## ✅ Summary

Saat develop SIPKOS:

1. ✅ Plan dulu sebelum code
2. ✅ Ikuti naming convention
3. ✅ Gunakan MVC structure
4. ✅ Implement security measures
5. ✅ Test sebelum deploy
6. ✅ Document changes
7. ✅ Monitor logs
8. ✅ Maintain code quality

Happy coding! 🎉
