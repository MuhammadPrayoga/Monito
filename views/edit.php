<?php
require "../includes/config.php";

// Mendapatkan data berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM transactions WHERE id = $id");
    $transaction = $result->fetch_assoc();

    if (!$transaction) {
        echo "Transaction not found.";
        exit;
    }
}

// Memproses data setelah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    $conn->query("UPDATE transactions SET description = '$description', amount = '$amount', date = '$date' WHERE id = $id");
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Transaksi</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $transaction['id'] ?>">
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <input type="text" name="description" class="form-control" value="<?= $transaction['description'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="<?= $transaction['amount'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" name="date" class="form-control" value="<?= $transaction['date'] ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="../index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>