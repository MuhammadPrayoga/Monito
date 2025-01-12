<?php require "../includes/config.php"; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    $conn->query("INSERT INTO transactions (description, amount, date) VALUES ('$description', '$amount', '$date')");
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Tambah Transaksi</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <input type="text" name="description" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Tambah</button>
            <a href="../index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>