<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include '../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $namamakanan = $_POST['namamakanan'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

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

        // Cek ekstensi file jika perlu (opsional)
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_ext)) {
            $error_message = "Ekstensi file tidak diizinkan.";
        }

        if (!isset($error_message)) {
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                // Simpan ke DB dengan foto
                $query = "INSERT INTO makanan (namamakanan, harga, deskripsi, stok, foto) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sdsss", $namamakanan, $harga, $deskripsi, $stok, $foto);
                $stmt->execute();
                header("Location: crudmakanan.php");
                exit;
            } else {
                $error_message = "Gagal mengunggah file.";
            }
        }
    } else {
        // Jika tidak upload foto, simpan tanpa kolom foto
        $query = "INSERT INTO makanan (namamakanan, harga, deskripsi, stok) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sdss", $namamakanan, $harga, $deskripsi, $stok);
        $stmt->execute();
        header("Location: crudmakanan.php");
        exit;
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
    <title>Kelola Makanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="crudmakanan.php">Makanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Tambah Makanan</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="namamakanan" class="form-label">Nama Makanan</label>
                <input type="text" name="namamakanan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Makanan</label>
                <input type="file" name="foto" class="form-control" required>
            </div>
            <button type="submit" name="add_product" class="btn btn-success">Tambah Makanan</button>
        </form>

        <h3 class="mt-5">Daftar Makanan</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nama Makanan</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM Makanan";
                $result = $conn->query($query);
                while ($product = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>{$product['namamakanan']}</td>
                    <td>{$product['harga']}</td>
                    <td>{$product['deskripsi']}</td>
                    <td>{$product['stok']}</td>
                    <td><img src='../assets/images/{$product['foto']}' alt='Foto Makanan' width='100'></td>
                    <td><a href='makananedit.php?id={$product['idmakanan']}' class='btn btn-primary btn-sm m-1'>Ubah</a> | 
                        <a href='makananhapus.php?id={$product['idmakanan']}' class='btn btn-danger btn-sm m-1'>Hapus</a></td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>