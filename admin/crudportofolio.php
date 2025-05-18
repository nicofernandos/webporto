<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include '../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_portofolio'])) {
    $namaportofolio = $_POST['namaportofolio'];
    $tahunmulai = $_POST['tahunmulai'];
    $deskripsi = $_POST['deskripsi'];
    $tahunakhir = $_POST['tahunakhir'];
    $error_message = null;

    // Handle image upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $foto = $_FILES['foto']['name'];
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($foto);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi ukuran maksimal 2MB
        if ($_FILES["foto"]["size"] > 2000000) {
            $error_message = "Maaf, ukuran file terlalu besar (maks 2MB).";
        }

        // Cek ekstensi file
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_ext)) {
            $error_message = "Ekstensi file tidak diizinkan.";
        }

        if (!isset($error_message)) {
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                // Simpan ke DB dengan foto
                $query = "INSERT INTO makanan (namaportofolio, tahunmulai, deskripsi, tahunakhir, foto) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssss", $namaportofolio, $tahunmulai, $deskripsi, $tahunakhir, $foto);
                if ($stmt->execute()) {
                    header("Location: crudportofolio.php");
                    exit;
                } else {
                    $error_message = "Gagal menyimpan data ke database.";
                }
            } else {
                $error_message = "Gagal mengunggah file.";
            }
        }
    } else {
        // Jika tidak upload foto, simpan tanpa kolom foto
        $query = "INSERT INTO makanan (namaportofolio, tahunmulai, deskripsi, tahunakhir) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $namaportofolio, $tahunmulai, $deskripsi, $tahunakhir);
        if ($stmt->execute()) {
            header("Location: crudportofolio.php");
            exit;
        } else {
            $error_message = "Gagal menyimpan data ke database.";
        }
    }

    // Jika ada error
    if (isset($error_message)) {
        echo "<script>alert('$error_message'); window.history.back();</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Portofolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
    .form-label {
        font-weight: bold;
    }

    .card-img-top {
        max-height: 200px;
        object-fit: cover;
    }

    .aksi-tombol {
        white-space: nowrap;
    }
    </style>
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
        <h2 class="text-center mb-4">Tambah Portofolio</h2>
        <form method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <label for="namaportofolio" class="form-label">Nama Portofolio</label>
                <input type="text" name="namaportofolio" class="form-control" id="namaportofolio" required>
            </div>
            <div class="col-md-6">
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
            <div class="col-md-6">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4" required></textarea>
            </div>
            <div class="col-md-6">
                <label for="tahunakhir" class="form-label">Tahun Akhir</label>
                <select class="form-control" name="tahunakhir" id="tahunakhir">
                    <option value="">Pilih Tahun Akhir (Jika Ada)</option>
                    <?php
                    $tahunAwalAkhir = 2010;
                    $tahunAkhirAkhir = date('Y');
                    while ($tahunAkhirAkhir >= $tahunAwalAkhir) {
                        echo '<option value="' . $tahunAkhirAkhir . '">' . $tahunAkhirAkhir . '</option>';
                        $tahunAkhirAkhir--;
                    }
                    ?>
                </select>
            </div>
            <div class="col-12">
                <label for="foto" class="form-label">Foto Portofolio</label>
                <input type="file" name="foto" class="form-control" id="foto" required>
            </div>
            <div class="col-12 text-center">
                <button type="submit" name="add_portofolio" class="btn btn-success">Tambah Portofolio</button>
            </div>
        </form>

        <h3 class="mt-5 mb-3">Daftar Portofolio</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Portofolio</th>
                        <th>Deskripsi</th>
                        <th>Tahun Awal</th>
                        <th>Tahun Akhir</th>
                        <th>Foto</th>
                        <th class="aksi-tombol">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM Makanan";
                    $result = $conn->query($query);
                    while ($product = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($product['namaportofolio']) . "</td>
                            <td>" . htmlspecialchars($product['deskripsi']) . "</td>
                            <td>" . htmlspecialchars($product['tahunmulai']) . "</td>
                            <td>" . htmlspecialchars($product['tahunakhir']) . "</td>
                            <td><img src='../assets/images/" . htmlspecialchars($product['foto']) . "' alt='Foto Portofolio' class='img-thumbnail' width='100'></td>
                            <td class='aksi-tombol'>
                                <a href='portofolioedit.php?id=" . htmlspecialchars($product['idportofolio']) . "' class='btn btn-primary btn-sm me-1'><i class='fas fa-edit'></i> Ubah</a>
                                <a href='portofoliohapus.php?id=" . htmlspecialchars($product['idportofolio']) . "' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Hapus</a>
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