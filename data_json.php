<?php
// =========================================================
// data_json.php - REST API sederhana untuk tabel users
// Endpoint: /ujian_asts/data_json.php
//
// GET  ?action=list            -> ambil semua data (default)
// GET  ?action=detail&id=1     -> ambil satu data
// POST action=create           -> tambah data baru
// POST action=update&id=1      -> ubah data
// POST action=delete&id=1      -> hapus data
// =========================================================

// Matikan tampilan notice/warning PHP ke layar supaya output
// SELALU JSON murni (notice/deprecation yang ikut tercetak
// adalah penyebab paling umum "gagal mengambil data JSON").
error_reporting(0);
ini_set('display_errors', '0');

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_REQUEST['action'] ?? ($method === 'GET' ? 'list' : '');

function input($key, $default = null) {
    return $_REQUEST[$key] ?? $default;
}

switch ($action) {

    // ---------------------------------------------------
    // LIST semua data
    // ---------------------------------------------------
    case 'list':
        $result = mysqli_query($conn, "SELECT * FROM users ORDER BY id ASC");
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    // ---------------------------------------------------
    // DETAIL satu data
    // ---------------------------------------------------
    case 'detail':
        $id = (int) input('id');
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            echo json_encode(["status" => "success", "data" => $row]);
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Data tidak ditemukan"]);
        }
        break;

    // ---------------------------------------------------
    // CREATE data baru
    // ---------------------------------------------------
    case 'create':
        $name    = trim(input('name', ''));
        $nisn    = trim(input('nisn', ''));
        $ttl     = trim(input('ttl', ''));
        $gender  = trim(input('gender', ''));
        $email   = trim(input('email', ''));
        $address = trim(input('address', ''));

        if ($name === '' || $email === '') {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Nama dan Email wajib diisi"]);
            break;
        }

        if (!preg_match('/^[0-9]{10}$/', $nisn)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "NISN harus persis 10 digit angka"]);
            break;
        }

        $stmt = mysqli_prepare($conn,
            "INSERT INTO users (name, nisn, ttl, gender, email, address) VALUES (?, ?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $nisn, $ttl, $gender, $email, $address);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode([
                "status"  => "success",
                "message" => "Data berhasil ditambahkan",
                "id"      => mysqli_insert_id($conn)
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
        break;

    // ---------------------------------------------------
    // UPDATE data
    // ---------------------------------------------------
    case 'update':
        $id      = (int) input('id');
        $name    = trim(input('name', ''));
        $nisn    = trim(input('nisn', ''));
        $ttl     = trim(input('ttl', ''));
        $gender  = trim(input('gender', ''));
        $email   = trim(input('email', ''));
        $address = trim(input('address', ''));

        if ($id <= 0 || $name === '' || $email === '') {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "ID, Nama, dan Email wajib diisi"]);
            break;
        }

        if (!preg_match('/^[0-9]{10}$/', $nisn)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "NISN harus persis 10 digit angka"]);
            break;
        }

        $stmt = mysqli_prepare($conn,
            "UPDATE users SET name=?, nisn=?, ttl=?, gender=?, email=?, address=? WHERE id=?"
        );
        mysqli_stmt_bind_param($stmt, "ssssssi", $name, $nisn, $ttl, $gender, $email, $address, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "Data berhasil diubah"]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
        break;

    // ---------------------------------------------------
    // DELETE data
    // ---------------------------------------------------
    case 'delete':
        $id = (int) input('id');
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "ID tidak valid"]);
            break;
        }

        $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "Data berhasil dihapus"]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Action tidak dikenali"]);
        break;
}

mysqli_close($conn);