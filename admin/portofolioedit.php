<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include '../db/connection.php';

// Get the portofolio ID from URL
$idportofolio = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the portofolio details
$query = "SELECT * FROM makanan WHERE idportofolio = $idportofolio";
$result = $conn->query($query);
$portofolio = $result->fetch_assoc();

if (!$portofolio) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Data portofolio tidak ditemukan. <a href='crudportofolio.php' class='alert-link'>Kembali ke daftar portofolio</a></div></div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_portofolio'])) {
    $namaportofolio = $_POST['namaportofolio'];
    $tahunmulai = $_POST['tahunmulai'];
    $deskripsi = $_POST['deskripsi'];
    $tahunakhir = $_POST['tahunakhir'];
    $error_message = null;
    $foto_lama = $portofolio['foto'];

    // Handle image upload if new file is provided
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $foto_baru = $_FILES['foto']['name'];
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($foto_baru);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file size (max 2MB)
        if ($_FILES["foto"]["size"] > 2000000) {
            $error_message = "Maaf, ukuran file terlalu besar (maks 2MB).";
        }

        // Allow certain file formats
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($imageFileType, $allowed_extensions)) {
            $error_message = "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
        }

        if (!isset($error_message)) {
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                // Update with new photo
                $update_query = "UPDATE makanan SET namaportofolio = ?, tahunmulai = ?, deskripsi = ?, tahunakhir = ?, foto = ? WHERE idportofolio = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("sssssi", $namaportofolio, $tahunmulai, $deskripsi, $tahunakhir, $foto_baru, $idportofolio);
                if ($stmt->execute()) {
                    // Delete old photo if a new one was uploaded and it exists
                    if (!empty($foto_lama) && $foto_lama !== $foto_baru && file_exists($target_dir . $foto_lama)) {
                        unlink($target_dir . $foto_lama);
                    }
                    header("Location: crudportofolio.php");
                    exit;
                } else {
                    $error_message = "Gagal memperbarui data portofolio.";
                }
            } else {
                $error_message = "Gagal mengunggah file.";
            }
        }
    } else {
        // Update without photo
        $update_query = "UPDATE makanan SET namaportofolio = ?, tahunmulai = ?, deskripsi = ?, tahunakhir = ? WHERE idportofolio = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssssi", $namaportofolio, $tahunmulai, $deskripsi, $tahunakhir, $idportofolio);
        if ($stmt->execute()) {
            header("Location: crudportofolio.php");
            exit;
        } else {
            $error_message = "Gagal memperbarui data portofolio.";
        }
    }

    // Display error message if any
    if (isset($error_message)) {
        echo "<script>alert('$error_message');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Portofolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
    .form-label {
        font-weight: bold;
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
                        <a class="nav-link" href="crudportofolio.php">Portofolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Edit Portofolio</h2>
        <form method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <label for="namaportofolio" class="form-label">Nama Portofolio</label>
                <input type="text" name="namaportofolio" class="form-control" id="namaportofolio"
                    value="<?php echo htmlspecialchars($portofolio['namaportofolio']); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="tahunmulai" class="form-label">Tahun Mulai</label>
                <select class="form-control" name="tahunmulai" id="tahunmulai" required>
                    <?php
                    $tahunAwalMulai = 2010;
                    $tahunAkhirMulai = date('Y');
                    while ($tahunAkhirMulai >= $tahunAwalMulai) {
                        $selected = ($tahunAkhirMulai == $portofolio['tahunmulai']) ? 'selected' : '';
                        echo '<option value="' . $tahunAkhirMulai . '" ' . $selected . '>' . $tahunAkhirMulai . '</option>';
                        $tahunAkhirMulai--;
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="5"
                    required><?php echo htmlspecialchars($portofolio['deskripsi']); ?></textarea>
            </div>
            <div class="col-md-6">
                <label for="tahunakhir" class="form-label">Tahun Akhir</label>
                <select class="form-control" name="tahunakhir" id="tahunakhir">
                    <option value="">Pilih Tahun Akhir (Jika Ada)</option>
                    <?php
                    $tahunAwalAkhir = 2010;
                    $tahunAkhirAkhir = date('Y');
                    while ($tahunAkhirAkhir >= $tahunAwalAkhir) {
                        $selected = ($tahunAkhirAkhir == $portofolio['tahunakhir']) ? 'selected' : '';
                        echo '<option value="' . $tahunAkhirAkhir . '" ' . $selected . '>' . $tahunAkhirAkhir . '</option>';
                        $tahunAkhirAkhir--;
                    }
                    ?>
                </select>
            </div>
            <div class="col-12">
                <label for="foto" class="form-label">Foto Portofolio</label><br>
                <?php if (!empty($portofolio['foto'])): ?>
                <img src="../assets/images/<?php echo htmlspecialchars($portofolio['foto']); ?>" alt="Foto Portofolio"
                    width="150" class="mb-2">
                <br>
                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                <?php endif; ?>
                <input type="file" name="foto" class="form-control" id="foto">
            </div>
            <div class="col-12 text-center">
                <button type="submit" name="update_portofolio" class="btn btn-success">Perbarui Portofolio</button>
                <a href="crudportofolio.php" class="btn btn-secondary ms-2">Batal</a>
            </div>
        </form>
        <br><br>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>