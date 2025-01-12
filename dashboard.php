<?php
session_start();
require "includes/config.php";

// Menghitung total pemasukan, pengeluaran, dan saldo
$totalIncome = 0;
$totalExpense = 0;
$incomeData = [];
$expenseData = [];
$months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

// Mengambil data dari database
$result = $conn->query("SELECT amount, MONTH(date) AS month FROM transactions");

// Menghitung total pemasukan dan pengeluaran per bulan
while ($row = $result->fetch_assoc()) {
    $amount = $row['amount'];
    $month = $row['month'] - 1;  // Menyesuaikan agar index dimulai dari 0 (Jan = 0)

    if ($amount > 0) {
        $incomeData[$month] = isset($incomeData[$month]) ? $incomeData[$month] + $amount : $amount;
    } else {
        $expenseData[$month] = isset($expenseData[$month]) ? $expenseData[$month] + abs($amount) : abs($amount);
    }
}

// Mengisi data bulan yang kosong
$incomeData = array_pad($incomeData, 12, 0);
$expenseData = array_pad($expenseData, 12, 0);

// Saldo = Total Pemasukan - Total Pengeluaran
$totalIncome = array_sum($incomeData);
$totalExpense = array_sum($expenseData);
$totalBalance = $totalIncome - $totalExpense;

// Fungsi untuk format rupiah
function rupiah($amount)
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Navbar -->
    <?php require "includes/navbar.php" ?>
    <div class="container mt-5">
        <h1 class="mb-4">Dashboard</h1>
        <div class="row">
            <!-- Total Income -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Pendapatan</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= rupiah($totalIncome) ?></h5>
                        <p class="card-text">Total pemasukan Anda.</p>
                    </div>
                </div>
            </div>
            <!-- Total Expense -->
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Total Pengeluaran</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= rupiah($totalExpense) ?></h5>
                        <p class="card-text">Total pengeluaran Anda.</p>
                    </div>
                </div>
            </div>
            <!-- Total Balance -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Saldo</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= rupiah($totalBalance) ?></h5>
                        <p class="card-text">Saldo Anda saat ini.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart: Pemasukan vs Pengeluaran -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Pemasukan vs Pengeluaran Per Bulan
                    </div>
                    <div class="card-body">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <a href="index.php" class="btn btn-secondary mt-3">Ke Transaksi</a>
    </div>

    <script>
        // Membuat chart menggunakan Chart.js
        var ctx = document.getElementById('financeChart').getContext('2d');
        var financeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>, // Menampilkan bulan
                datasets: [{
                    label: 'Pemasukan',
                    data: <?php echo json_encode($incomeData); ?>, // Data pemasukan
                    backgroundColor: 'rgba(40, 167, 69, 0.5)', // Warna hijau
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }, {
                    label: 'Pengeluaran',
                    data: <?php echo json_encode($expenseData); ?>, // Data pengeluaran
                    backgroundColor: 'rgba(220, 53, 69, 0.5)', // Warna merah
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return 'Rp ' + value.toLocaleString(); // Format rupiah pada sumbu Y
                            }
                        }
                    }
                }
            }
        });
    </script>
    <!-- Footer -->
    <?php require "includes/footer.php" ?>

    <!-- Javascript -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>