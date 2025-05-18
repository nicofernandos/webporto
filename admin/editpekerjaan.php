<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include '../db/connection.php';

$idpekerjaan = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM pekerjaan WHERE idpekerjaan = $idpekerjaan";
$result = $conn->query($query);
$pekerjaan = $result->fetch_assoc();

if (!$pekerjaan) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Data pekerjaan tidak ditemukan. <a href='crudpekerjaan.php' class='alert-link'>Kembali ke daftar pekerjaan</a></div></div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatepekerjaan'])) {
    $namapekerjaan = $_POST['namapekerjaan'];
    $deskripsipekerjaan = $_POST['deskripsipekerjaan'];
    $tahunmulai = $_POST['tahunmulai'];
    $tahunakhir = $_POST['tahunakhir'];
    $error_message = null;
    $fotopekerjaan_lama = $pekerjaan['fotopekerjaan']; // Simpan nama file foto lama

    if (isset($_FILES['fotopekerjaan']) && $_FILES['fotopekerjaan']['error'] === 0) {
        $fotopekerjaan_baru = $_FILES['fotopekerjaan']['name'];
        $target_dir = '../assets/images/';
        $target_file = $target_dir . basename($fotopekerjaan_baru);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($_FILES["fotopekerjaan"]["size"] > 2000000) {
            $error_message = "Ukuran gambar melebihi (maks 2MB).";
        }

        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_ext)) {
            $error_message = "Ekstensi file tidak diizinkan.";
        }

        if (!isset($error_message)) {
            if (move_uploaded_file($_FILES['fotopekerjaan']['tmp_name'], $target_file)) {
                // Hapus foto lama jika ada dan berbeda dengan yang baru
                if (!empty($fotopekerjaan_lama) && $fotopekerjaan_lama !== $fotopekerjaan_baru && file_exists($target_dir . $fotopekerjaan_lama)) {
                    unlink($target_dir . $fotopekerjaan_lama);
                }
                $fotopekerjaan = $fotopekerjaan_baru;
            } else {
                $error_message = "Gagal mengunggah file.";
                $fotopekerjaan = $fotopekerjaan_lama; // Gunakan foto lama jika upload gagal
            }
        } else {
            $fotopekerjaan = $fotopekerjaan_lama; // Gunakan foto lama jika ada error validasi
        }
    } else {
        $fotopekerjaan = $fotopekerjaan_lama; // Jika tidak ada upload file baru, gunakan foto lama
    }

    if (!isset($error_message)) {
        $update_query = "UPDATE pekerjaan SET namapekerjaan = ?, deskripsipekerjaan = ?, fotopekerjaan = ?, tahunmulai = ?, tahunakhir = ? WHERE idpekerjaan = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssssi", $namapekerjaan, $deskripsipekerjaan, $fotopekerjaan, $tahunmulai, $tahunakhir, $idpekerjaan);
        if ($stmt->execute()) {
            header("Location: crudpekerjaan.php");
            exit;
        } else {
            $error_message = "Gagal memperbarui data pekerjaan.";
        }
    }

    if (isset($error_message)) {
        echo "<script>alert('$error_message');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pekerjaan</title>
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
                        <a class="nav-link" href="crudmakanan.php">Portofolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="crudpendidikan.php">Pendidikan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="crudpekerjaan.php">Pekerjaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Pekerjaan</h2>
        <form method="POST" enctype="multipart/form-data" class="row g-3">
            <input type="hidden" name="idpekerjaan" value="<?= htmlspecialchars($pekerjaan['idpekerjaan']) ?>">
            <div class="col-md-6">
                <label for="namapekerjaan" class="form-label">Nama Pekerjaan</label>
                <input type="text" name="namapekerjaan" class="form-control" id="namapekerjaan"
                    value="<?= htmlspecialchars($pekerjaan['namapekerjaan']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="deskripsipekerjaan" class="form-label">Deskripsi Pekerjaan</label>
                <input type="text" name="deskripsipekerjaan" class="form-control" id="deskripsipekerjaan"
                    value="<?= htmlspecialchars($pekerjaan['deskripsipekerjaan']) ?>" required>
            </div>
            <div class="col-md-3">
                <label for="tahunmulai" class="form-label">Tahun Mulai</label>
                <select class="form-control" name="tahunmulai" id="tahunmulai" required>
                    <?php
                    $tahunAwalMulai = 2010;
                    $tahunAkhirMulai = date('Y');
                    while ($tahunAkhirMulai >= $tahunAwalMulai) {
                        $selectedMulai = ($tahunAkhirMulai == $pendidikan['tahunmulai']) ? 'selected' : '';
                        echo '<option value="' . $tahunAkhirMulai . '" ' . $selectedMulai . '>' . $tahunAkhirMulai . '</option>';
                        $tahunAkhirMulai--;
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="tahunakhir" class="form-label">Tahun Akhir</label>
                <select class="form-control" name="tahunakhir" id="tahunakhir">
                    <option value="">Pilih Tahun Akhir</option>
                    <?php
                    $tahunAwalAkhir = 2010;
                    $tahunAkhirAkhir = date('Y');
                    while ($tahunAkhirAkhir >= $tahunAwalAkhir) {
                        $selectedAkhir = ($tahunAkhirAkhir == $pendidikan['tahunakhir']) ? 'selected' : '';
                        echo '<option value="' . $tahunAkhirAkhir . '" ' . $selectedAkhir . '>' . $tahunAkhirAkhir . '</option>';
                        $tahunAkhirAkhir--;
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="fotopekerjaan" class="form-label">Foto Pekerjaan</label>
                <input type="file" name="fotopekerjaan" class="form-control" id="fotopekerjaan">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                <?php if (!empty($pendidikan['fotopekerjaan'])): ?>
                <img src="../assets/images/<?= htmlspecialchars($pendidikan['fotopekerjaan']) ?>"
                    alt="Foto Pendidikan Saat Ini" class="mt-2 img-thumbnail" width="100">
                <?php endif; ?>
            </div>
            <div class="col-12 text-center">
                <button type="submit" name="updatepekerjaan" class="btn btn-primary">Simpan Perubahan</button>
                <a href="crudpekerjaan.php" class="btn btn-secondary ms-2">Batal</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>