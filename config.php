<?php
// =========================================================
// config.php - Koneksi ke database ujian_asts
// Sesuaikan host/user/password dengan server lokal Anda
// (XAMPP/Laragon default: user root, password kosong)
// =========================================================

// Jangan lempar exception fatal jika koneksi gagal - biar kita
// yang menangani pesannya sendiri di bawah dan tetap balas JSON.
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "ujian_asts";

$conn = @mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        "status"  => "error",
        "message" => "Koneksi database gagal: " . mysqli_connect_error()
    ]);
    exit;
}

mysqli_set_charset($conn, "utf8mb4");