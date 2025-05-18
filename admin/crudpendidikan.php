<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php'); // Perbaikan: Spasi setelah 'Location:' dan tanpa spasi sebelum '.php'
    exit;
}

include '../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addpendidikan'])) {
    $namapendidikan = $_POST['namapendidikan'];
    $deskripsipendidikan = $_POST['deskripsipendidikan'];
    $tahunmulai = $_POST['tahunmulai'];
    $tahunakhir = $_POST['tahunakhir'];
    $error_message = null; // Inisialisasi pesan error

    if (isset($_FILES['fotopendidikan']) && $_FILES['fotopendidikan']['error'] === 0) {
        $fotopendidikan = $_FILES['fotopendidikan']['name'];
        $target_dir = '../assets/images/';
        $target_file = $target_dir . basename($fotopendidikan);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Perbaikan: Variabel typo

        if ($_FILES["fotopendidikan"]["size"] > 2000000) { // Perbaikan: Sintaks akses size array
            $error_message = "Ukuran gambar melebihi (maks 2MB).";
        }

        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_ext)) { // Perbaikan: Variabel typo
            $error_message = "Ekstensi file tidak diizinkan.";
        }

        if (!isset($error_message)) {
            if (move_uploaded_file($_FILES['fotopendidikan']['tmp_name'], $target_file)) {
                // Simpan ke DB dengan foto
                $query = "INSERT INTO pendidikan (namapendidikan, deskripsipendidikan, fotopendidikan, tahunmulai, tahunakhir) VALUES (?, ?, ?, ?, ?)"; // Perbaikan: Nama tabel dan urutan kolom
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssss", $namapendidikan, $deskripsipendidikan, $fotopendidikan, $tahunmulai, $tahunakhir); // Perbaikan: Jumlah dan tipe binding parameter
                $stmt->execute();
                header("Location: crudpendidikan.php"); // Perbaikan: Nama file redirect
                exit;
            } else {
                $error_message = "Gagal mengunggah file.";
            }
        }
    } else {
        // Jika tidak upload foto, simpan tanpa kolom foto
        $query = "INSERT INTO pendidikan (namapendidikan, deskripsipendidikan, tahunmulai, tahunakhir) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $namapendidikan, $deskripsipendidikan, $tahunmulai, $tahunakhir); // Perbaikan: Jumlah dan tipe binding parameter
        $stmt->execute();
        header("Location: crudpendidikan.php"); // Perbaikan: Nama file redirect
        exit;
    }

    // Jika ada error
    if (isset($error_message)) {
        echo "<script>alert('$error_message'); window.history.back();</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Pendidikan</title>
    <link rel="icon" href="assets/images/favicon.jpg" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=PT+Serif:wght@400;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="crudportofolio.php">Portofolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="crudpendidikan.php">Pendidikan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="crudpekerjaan.php">Pekerjaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Tambah Pendidikan</h2>
        <form method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <label for="namapendidikan" class="form-label">Nama Pendidikan</label>
                <input type="text" name="namapendidikan" class="form-control" id="namapendidikan" required>
            </div>
            <div class="col-md-6">
                <label for="deskripsipendidikan" class="form-label">Deskripsi Pendidikan</label>
                <input type="text" name="deskripsipendidikan" class="form-control" id="deskripsipendidikan" required>
            </div>
            <div class="col-md-3">
                <label for="tahunmulai" class="form-label">Tahun Mulai</label>
                <select class="form-control" name="tahunmulai" id="tahunmulai" required>
                    <?php
            $tahunAwalMulai = 2010;
            $tahunAkhirMulai = date('Y');
            while ($tahunAkhirMulai >= $tahunAwalMulai) {
                echo '<option value="' . $tahunAkhirMulai . '">' . $tahunAkhirMulai . '</option>';
                $tahunAkhirMulai--;
            }
            ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="tahunakhir" class="form-label">Tahun Akhir</label>
                <select class="form-control" name="tahunakhir" id="tahunakhir" required>
                    <?php
            $tahunAwalAkhir = 2010;
            $tahunAkhirAkhir = date('Y');
            echo '<option value="">Pilih Tahun Akhir</option>'; // Opsi default
            while ($tahunAkhirAkhir >= $tahunAwalAkhir) {
                echo '<option value="' . $tahunAkhirAkhir . '">' . $tahunAkhirAkhir . '</option>';
                $tahunAkhirAkhir--;
            }
            ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="fotopendidikan" class="form-label">Foto Pendidikan</label>
                <input type="file" name="fotopendidikan" class="form-control" id="fotopendidikan" required>
            </div>
            <div class="col-12 text-center">
                <button type="submit" name="addpendidikan" class="btn btn-success">Tambah Pendidikan</button>
            </div>
        </form>

        <h3 class="mt-5 mb-3">Daftar Pendidikan</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Pendidikan</th>
                        <th>Deskripsi Pendidikan</th>
                        <th>Foto Pendidikan</th>
                        <th>Tahun Mulai</th>
                        <th>Tahun Akhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM Pendidikan";
                    $result = $conn->query($query);
                    while ($product = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($product['namapendidikan']) . "</td>
                            <td>" . htmlspecialchars($product['deskripsipendidikan']) . "</td>
                            <td><img src='../assets/images/" . htmlspecialchars($product['fotopendidikan']) . "' alt='Foto Pendidikan' width='100' class='img-thumbnail'></td>
                            <td>" . htmlspecialchars($product['tahunmulai']) . "</td>
                            <td>" . htmlspecialchars($product['tahunakhir']) . "</td>
                            <td>
                                <a href='editpendidikan.php?id=" . htmlspecialchars($product['idpendidikan']) . "' class='btn btn-primary btn-sm me-1'><i class='fas fa-edit'></i> Ubah</a>
                                <a href='hapuspendidikan.php?id=" . htmlspecialchars($product['idpendidikan']) . "' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Hapus</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>