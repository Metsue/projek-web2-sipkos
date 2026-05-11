# DOKUMENTASI IMPLEMENTASI SIPKOS

## Penjelasan Konsep OOP & MVC Implementation

### 1. OBJECT ORIENTED PROGRAMMING (OOP)

#### A. Encapsulation
Merangkum data dan method dalam satu unit (class) dan membatasi akses.

**Contoh di Model.php:**
```php
class Model {
    // Protected - hanya bisa diakses di dalam class dan child class
    protected $db;
    protected $table;
    
    // Private - hanya bisa diakses di dalam class ini
    private $last_error;
    
    // Public - bisa diakses dari mana saja
    public function getAll() { ... }
}
```

**Penjelasan:**
- `protected` properties digunakan untuk data yang boleh di-inherit
- `private` properties untuk data yang terbatas akses
- Method dibuat `public` untuk interface yang diakses dari luar

#### B. Inheritance
Menurunkan sifat/method dari class induk ke class anak.

**Contoh di Kamar.php:**
```php
class Kamar extends Model {
    protected $table = 'kamar';
    
    // Kamar bisa menggunakan method dari Model
    // seperti getAll(), getById(), insert(), update(), delete()
}
```

**Penjelasan:**
- `Kamar` mewarisi semua method dari `Model`
- Tidak perlu menulis ulang method dasar CRUD
- Bisa menambahkan method spesifik untuk Kamar

#### C. Polymorphism
Kemampuan object untuk mengambil berbagai bentuk.

**Contoh:**
```php
// Base Model method
public function getAll($limit = null, $offset = 0) { ... }

// Setiap child class bisa override method ini
class Kamar extends Model {
    public function getAll($limit = null, $offset = 0) {
        // Custom implementation untuk Kamar
    }
}
```

#### D. Abstraction
Menyembunyikan kompleksitas dan hanya menampilkan interface yang diperlukan.

**Contoh di Model.php:**
```php
public function insert($data = []) {
    // Kompleks logic untuk insert
    // Tapi dari luar hanya dipanggil:
    $kamar->insert(['nomor_kamar' => 'A01', 'harga' => 1000000]);
}
```

#### E. Constructor
Method yang dipanggil otomatis saat object dibuat.

```php
class Model {
    public function __construct() {
        // Otomatis dijalankan saat object dibuat
        $database = new Database();
        $this->db = $database->connect();
    }
}

// Saat digunakan:
$kamar = new Kamar();  // Constructor otomatis jalan
```

---

### 2. MODEL VIEW CONTROLLER (MVC)

#### A. Model (Data Layer)
File: `app/models/*.php`

Bertanggung jawab:
- Query ke database
- Validasi data
- Business logic terkait data

**Contoh Kamar.php:**
```php
class Kamar extends Model {
    protected $table = 'kamar';  // Tabel yang digunakan
    
    // Method spesifik untuk Kamar
    public function getByStatus($status) {
        return $this->getWhere(['status' => $status]);
    }
    
    public function countAvailable() {
        return $this->count(['status' => 'tersedia']);
    }
}
```

**Alur Penggunaan Model:**
```
Query DB → Process Data → Return Result
```

#### B. View (Presentation Layer)
File: `app/views/*.php`

Bertanggung jawab:
- Menampilkan data
- Interaksi dengan user
- HTML/CSS/JavaScript

**Contoh admin/kamar/index.php:**
```html
<?php foreach ($kamar_list as $kamar): ?>
    <tr>
        <td><?php echo htmlspecialchars($kamar['nomor_kamar']); ?></td>
        <td><?php echo number_format($kamar['harga'], 0, ',', '.'); ?></td>
    </tr>
<?php endforeach; ?>
```

**Alur Penggunaan View:**
```
Receive Data → Render HTML → Send to Browser
```

#### C. Controller (Logic Layer)
File: `app/controllers/*.php`

Bertanggung jawab:
- Menerima request dari user
- Memanggil Model
- Memanggil View dengan data

**Contoh AdminController:**
```php
public function kamarIndex() {
    // 1. Load Model
    require_once APP . 'models/Kamar.php';
    $kamar_model = new Kamar();
    
    // 2. Query data
    $kamar_list = $kamar_model->getAll();
    
    // 3. Pass ke View
    $this->view('admin/kamar/index', [
        'kamar_list' => $kamar_list
    ]);
}
```

**Alur Penggunaan Controller:**
```
Request → Load Model → Get Data → Load View
```

#### D. MVC Flow Lengkap
```
1. USER REQUEST (http://localhost/admin/kamar)
        ↓
2. ROUTER (routes/web.php)
   GET /admin/kamar → AdminController@kamarIndex
        ↓
3. CONTROLLER (AdminController)
   - Load Model
   - Query data
   - Prepare data
        ↓
4. MODEL (Kamar Model)
   - Connect to DB
   - Execute query
   - Return data
        ↓
5. CONTROLLER (Continue)
   - Pass data to View
        ↓
6. VIEW (index.php)
   - Render HTML
   - Display data
        ↓
7. RESPONSE to USER (HTML Page)
```

---

### 3. CLASS STRUCTURE EXPLANATION

#### A. Base Model Class
File: `app/core/Model.php`

**Method Utama:**
```php
$model->getAll()              // Get semua data
$model->getById($id)          // Get by ID
$model->getWhere($where)      // Get dengan kondisi
$model->insert($data)         // Insert data
$model->update($data, $where) // Update data
$model->delete($where)        // Delete data
$model->count($where)         // Count data
```

**Contoh Penggunaan:**
```php
$kamar = new Kamar();

// Get all
$all_kamar = $kamar->getAll();

// Get specific
$kamar_a01 = $kamar->getById(1, 'id_kamar');

// Get dengan kondisi
$kamar_tersedia = $kamar->getWhere(['status' => 'tersedia']);

// Insert
$id = $kamar->insert([
    'nomor_kamar' => 'A01',
    'harga' => 1000000,
    'status' => 'tersedia'
]);

// Update
$kamar->update(
    ['status' => 'terisi'],           // Data to update
    ['id_kamar' => 1]                 // WHERE clause
);

// Delete
$kamar->delete(['id_kamar' => 1]);

// Count
$total = $kamar->count();
$tersedia = $kamar->count(['status' => 'tersedia']);
```

#### B. Base Controller Class
File: `app/core/Controller.php`

**Method Utama:**
```php
$this->view()          // Load view
$this->redirect()      // Redirect ke halaman lain
$this->post()          // Get POST data
$this->get()           // Get GET data
$this->isLoggedIn()    // Check login
$this->isAdmin()       // Check admin role
$this->setFlash()      // Set flash message
$this->getFlash()      // Get flash message
$this->json()          // Return JSON response
$this->validate()      // Validate input
```

**Contoh Penggunaan:**
```php
public function kamarCreate() {
    // Load view
    $this->view('admin/kamar/create', [
        'title' => 'Tambah Kamar'
    ]);
}

public function kamarStore() {
    // Check method
    if (!$this->isPost()) {
        $this->redirect('admin/kamar');
    }
    
    // Get data
    $nomor_kamar = $this->post('nomor_kamar');
    $harga = $this->post('harga');
    
    // Validate
    $errors = $this->validate([
        'nomor_kamar' => ['required'],
        'harga' => ['required', 'numeric']
    ]);
    
    if (!empty($errors)) {
        $this->setFlash('error', 'Validasi gagal');
        $this->redirect('admin/kamar/create');
    }
    
    // Process...
}
```

#### C. Router Class
File: `app/core/Router.php`

**Cara Kerja:**
1. Menerima semua request
2. Parse URL request
3. Match dengan route yang terdaftar
4. Call controller method yang sesuai

**Contoh Routing:**
```php
// In routes/web.php
$router->get('/admin/kamar', 'admin@kamarIndex');
$router->post('/admin/kamar/store', 'admin@kamarStore');
$router->get('/admin/kamar/edit/:id', 'admin@kamarEdit');

// Saat request /admin/kamar/edit/5?id=5
// Router akan:
// 1. Match dengan pattern /admin/kamar/edit/:id
// 2. Extract parameter id = 5
// 3. Call AdminController@kamarEdit()
// 4. $_GET['id'] otomatis set ke 5
```

---

### 4. DATABASE LAYER

#### A. Database Class
File: `config/database.php`

**Tanggung Jawab:**
- Create PDO connection
- Handle connection errors
- Provide connection to Model

**Contoh:**
```php
class Database {
    private $host = 'localhost';
    private $db_name = 'sipkos_db';
    private $user = 'root';
    private $pass = '';
    
    public function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name}";
        return new PDO($dsn, $this->user, $this->pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
```

#### B. Prepared Statements (SQL Injection Prevention)
```php
// Cara Salah (Rentan SQL Injection):
$query = "SELECT * FROM users WHERE email = '" . $_POST['email'] . "'";

// Cara Benar (Aman):
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $this->db->prepare($query);
$stmt->execute([$_POST['email']]);
```

---

### 5. AUTHENTICATION FLOW

#### Login Process:
```
1. User input email & password → Form submit
         ↓
2. Router → AuthController@processLogin()
         ↓
3. Validate input
         ↓
4. Find user di database
         ↓
5. Verify password dengan password_verify()
         ↓
6. Set session:
   $_SESSION['user_id'] = user ID
   $_SESSION['user'] = user data
         ↓
7. Redirect ke dashboard sesuai role
```

#### Register Process:
```
1. User input form data → Form submit
         ↓
2. Router → AuthController@processRegister()
         ↓
3. Validate input
         ↓
4. Check email & username duplicate
         ↓
5. Hash password dengan password_hash()
         ↓
6. Insert ke database
         ↓
7. Redirect ke login
```

---

### 6. CRUD OPERATION EXAMPLE

**CREATE (Insert):**
```php
public function kamarStore() {
    $kamar = new Kamar();
    $result = $kamar->insert([
        'nomor_kamar' => $this->post('nomor_kamar'),
        'tipe_kamar' => $this->post('tipe_kamar'),
        'harga' => $this->post('harga'),
        'status' => 'tersedia'
    ]);
    
    if ($result) {
        $this->setFlash('success', 'Kamar ditambahkan');
    }
}
```

**READ (Select):**
```php
public function kamarIndex() {
    $kamar = new Kamar();
    $kamar_list = $kamar->getAll();
    $this->view('admin/kamar/index', [
        'kamar_list' => $kamar_list
    ]);
}
```

**UPDATE (Modify):**
```php
public function kamarUpdate() {
    $id = $this->post('id_kamar');
    $kamar = new Kamar();
    $result = $kamar->update([
        'nomor_kamar' => $this->post('nomor_kamar'),
        'harga' => $this->post('harga')
    ], ['id_kamar' => $id]);
    
    if ($result) {
        $this->setFlash('success', 'Kamar diupdate');
    }
}
```

**DELETE (Remove):**
```php
public function kamarDelete() {
    $id = $this->get('id');
    $kamar = new Kamar();
    $result = $kamar->delete(['id_kamar' => $id]);
    
    if ($result) {
        $this->setFlash('success', 'Kamar dihapus');
    }
}
```

---

### 7. FILE UPLOAD HANDLING

#### Contoh di AdminController:
```php
private function uploadFoto($file) {
    // 1. Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        return false;
    }
    
    // 2. Validate file size (max 2MB)
    $max_size = 2 * 1024 * 1024;
    if ($file['size'] > $max_size) {
        return false;
    }
    
    // 3. Create upload directory
    $upload_dir = UPLOADS . 'kamar/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // 4. Generate unique filename
    $filename = time() . '_' . rand(1000, 9999) . '.' . 
                pathinfo($file['name'], PATHINFO_EXTENSION);
    $filepath = $upload_dir . $filename;
    
    // 5. Move file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return $filename;
    }
    
    return false;
}
```

#### Penggunaan:
```php
if (!empty($_FILES['foto']['name'])) {
    $foto = $this->uploadFoto($_FILES['foto']);
    if ($foto) {
        // Simpan nama file ke database
        $kamar->update(['foto' => $foto], ['id_kamar' => $id]);
    }
}
```

---

### 8. SESSION MANAGEMENT

#### Set Session:
```php
$_SESSION['user_id'] = 123;
$_SESSION['user'] = [
    'id_user' => 123,
    'nama' => 'John Doe',
    'email' => 'john@example.com',
    'role' => 'admin'
];
```

#### Check Session:
```php
if (!isset($_SESSION['user_id'])) {
    // Not logged in
    $this->redirect('login');
}

if ($_SESSION['user']['role'] !== 'admin') {
    // Not admin
    $this->redirect('login');
}
```

#### Get Session:
```php
$user_id = $_SESSION['user_id'];
$user_data = $_SESSION['user'];
```

#### Destroy Session (Logout):
```php
session_destroy();
$this->redirect('login');
```

---

### 9. INPUT VALIDATION

#### Validation Rules:
```php
$errors = $this->validate([
    'email' => ['required', 'email'],
    'password' => ['required', 'min:6'],
    'harga' => ['required', 'numeric']
]);

// Di Controller:
if (!empty($errors)) {
    $this->setFlash('error', 'Validasi gagal');
    $this->redirect('back');
}
```

#### Custom Validation:
```php
$email = $this->post('email');
if ($user_model->emailExists($email)) {
    $this->setFlash('error', 'Email sudah terdaftar');
    $this->redirect('register');
}
```

---

### 10. BEST PRACTICES IMPLEMENTED

1. **DRY (Don't Repeat Yourself)**
   - Base Model untuk method CRUD umum
   - Base Controller untuk method umum
   - Template layout untuk reusable HTML

2. **SOLID Principles**
   - Single Responsibility: Setiap class punya tanggung jawab 1
   - Open/Closed: Bisa extended tanpa modify
   - Liskov Substitution: Child bisa replace parent
   - Interface Segregation: Interface kecil & spesifik
   - Dependency Inversion: Depend on abstraction

3. **Security**
   - Password hashing dengan bcrypt
   - Prepared statements untuk SQL
   - Input sanitization dengan htmlspecialchars
   - Session-based authentication

4. **Code Organization**
   - Clear folder structure
   - Naming convention yang konsisten
   - Separation of concerns
   - Reusable components

5. **Performance**
   - Database indexing
   - Pagination untuk large datasets
   - Query optimization
   - Caching (bisa ditambah)

---

## KESIMPULAN

SIPKOS mengimplementasikan konsep OOP dan MVC dengan baik:

- **OOP:** Encapsulation, Inheritance, Polymorphism, Abstraction
- **MVC:** Model untuk data, View untuk display, Controller untuk logic
- **Security:** Password hashing, SQL injection prevention, session management
- **Scalability:** Base classes untuk reusability, easy to extend
- **Maintainability:** Clean code, proper organization, documentation

Dengan struktur ini, aplikasi mudah dikembangkan, ditest, dan dimaintain.
