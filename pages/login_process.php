<?php
include "../conf/conn.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Ambil input dari pengguna
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    // Query untuk mengambil data user berdasarkan username
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Cek apakah username ditemukan
    if ($row = mysqli_fetch_assoc($result)) {
        // Cek password secara langsung (TANPA password_hash)
        if ($password == $row['password']) {
            session_regenerate_id(true);
            $_SESSION['id_admin'] = $row['id_admin'];
            $_SESSION['username'] = $row['username'];

            echo '<script>alert("Selamat Datang, ' . htmlspecialchars($row['username']) . '!");
            window.location.href="../index.php";</script>';
        } else {
            echo '<script>alert("Password salah!"); window.location.href="login.php";</script>';
        }
    } else {
        echo '<script>alert("Username tidak ditemukan!"); window.location.href="login.php";</script>';
    }

    // Tutup statement dan koneksi
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo '<script>window.location.href="login.php";</script>';
}
?>
