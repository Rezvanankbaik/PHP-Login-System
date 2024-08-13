<?php
// Memasukkan file koneksi database
require_once '../config/connection.php';

// Mendefinisikan kelas UserModel yang digunakan untuk berinteraksi dengan tabel 'users' di database
class UserModel
{
    // Properti untuk menyimpan objek koneksi database
    private $conn;

    // Konstruktor kelas yang dipanggil saat objek UserModel dibuat
    public function __construct()
    {
        // Membuka koneksi ke database menggunakan fungsi openConnection()
        $this->conn = openConnection();
    }

    // Metode untuk mendaftarkan pengguna baru ke database
    public function register($name, $gender, $date_of_birth, $email, $phone_number, $password)
    {
        // Meng-hash password sebelum menyimpannya di database untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // SQL query untuk menyisipkan data pengguna baru ke tabel 'users'
        $sql = "INSERT INTO users (name, gender, date_of_birth, email, phone_number, password) VALUES (?, ?, ?, ?, ?, ?)";
        
        // Mempersiapkan statement SQL untuk dieksekusi
        $stmt = $this->conn->prepare($sql);
        
        // Mengikat parameter-parameter ke statement SQL (menggunakan tanda tanya sebagai placeholder)
        $stmt->bind_param("ssssss", $name, $gender, $date_of_birth, $email, $phone_number, $hashed_password);

        // Menjalankan statement dan memeriksa apakah eksekusi berhasil
        if ($stmt->execute()) {
            // Jika berhasil, arahkan pengguna ke halaman 'count.php'
            header("Location: ../views/count.php");
        } else {
            // Jika gagal, tampilkan pesan error beserta detail error dari database
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    // Metode untuk mengambil data pengguna berdasarkan email (digunakan untuk login)
    public function login($email)
    {
        // SQL query untuk memilih pengguna berdasarkan email
        $sql = "SELECT * FROM users WHERE email=?";
        
        // Mempersiapkan statement SQL untuk dieksekusi
        $stmt = $this->conn->prepare($sql);
        
        // Mengikat parameter email ke statement SQL
        $stmt->bind_param("s", $email);
        
        // Menjalankan statement SQL
        $stmt->execute();
        
        // Mendapatkan hasil dari eksekusi query
        $result = $stmt->get_result();

        // Memeriksa apakah tepat satu pengguna ditemukan
        if ($result->num_rows == 1) {
            // Jika ya, ambil data pengguna sebagai array asosiatif
            $user = $result->fetch_assoc();
            return $user;
        } else {
            // Jika tidak, kembalikan null
            return null;
        }
    }

    // Metode untuk mengambil data pengguna berdasarkan ID
    public function getUserById($id)
    {
        // SQL query untuk memilih pengguna berdasarkan ID
        $sql = "SELECT * FROM users WHERE id=?";
        
        // Mempersiapkan statement SQL untuk dieksekusi
        $stmt = $this->conn->prepare($sql);
        
        // Mengikat parameter ID ke statement SQL
        $stmt->bind_param("i", $id);
        
        // Menjalankan statement SQL
        $stmt->execute();
        
        // Mendapatkan hasil dari eksekusi query
        $result = $stmt->get_result();

        // Memeriksa apakah tepat satu pengguna ditemukan
        if ($result->num_rows == 1) {
            // Jika ya, ambil data pengguna sebagai array asosiatif
            $user = $result->fetch_assoc();
            return $user;
        } else {
            // Jika tidak, kembalikan null
            return null;
        }
    }

    // Metode untuk menutup koneksi database
    public function closeConnection()
    {
        // Menutup koneksi yang terbuka
        $this->conn->close();
    }
}
?>
