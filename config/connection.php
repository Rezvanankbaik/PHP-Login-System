

<?php

// Fungsi untuk membuka koneksi ke database MySQL
function openConnection()
{
    // Menyimpan informasi koneksi database
    $hostname = "localhost"; // Alamat server database (biasanya 'localhost' untuk server lokal)
    $username = "root";      // Nama pengguna untuk login ke database
    $password = "";          // Kata sandi untuk login ke database (kosong dalam contoh ini)
    $database = "php_login_system"; // Nama database yang akan diakses

    // Membuat koneksi ke database menggunakan objek mysqli
    $conn = new mysqli($hostname, $username, $password, $database);

    // Memeriksa apakah koneksi berhasil atau gagal
    if ($conn->connect_error) {
        // Jika terjadi kesalahan koneksi, hentikan eksekusi dan tampilkan pesan error
        die("Connection failed: " . $conn->connect_error);
    }

    // Jika koneksi berhasil, kembalikan objek koneksi ($conn)
    return $conn;
}
?>
