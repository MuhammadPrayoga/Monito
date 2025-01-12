<!-- PageHeader -->
<?php require "includes/header.php" ?>
<!-- ./PageHeader -->

<body>
    <!-- Navbar -->
    <?php require "includes/navbar.php" ?>

    <div class="container mt-5">
        <h1 class="mb-4">Transaksi</h1>
        <a href="views/add.php" class="btn btn-danger mb-3">Tambah Transaksi</a>
        <table id="transactionsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM transactions");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['description']}</td>
                            <td>" . formatRupiah($row['amount']) . "</td>
                            <td>{$row['date']}</td>
                            <td>
                                <a href='views/edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='views/delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <?php require "includes/footer.php" ?>


    <script src="assets/jquery/jquery-3.7.1.js"></script>
    <script src="assets/datatables/dataTables.js"></script>
    <script src="assets/datatables/dataTables.bootstrap5.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#transactionsTable').DataTable();
        });
    </script>
</body>

</html>