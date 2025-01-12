<?php
require "../includes/config.php";

// Mengecek apakah ID tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Menghapus data berdasarkan ID
    $conn->query("DELETE FROM transactions WHERE id = $id");

    // Redirect kembali ke halaman utama
    header("Location: ../index.php");
} else {
    echo "Invalid request.";
}
