<?php
// Menghancurkan semua data sesi yang ada
session_destroy();

// Menghapus semua variabel sesi yang ada
session_unset();

// Mengarahkan pengguna ke halaman login setelah logout
header("Location: ../views/login.php");

// Menghentikan eksekusi script untuk memastikan tidak ada kode yang dijalankan setelah pengalihan
exit;
?>
