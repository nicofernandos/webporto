<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include '../db/connection.php';

// Get the product ID from URL
$idmakanan = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the product details
$query = "SELECT * FROM Makanan WHERE idmakanan = $idmakanan";
$result = $conn->query($query);
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namamakanan = $_POST['namamakanan'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    // Handle image upload if new file is provided
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $foto = $_FILES['foto']['name'];
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($foto);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file size (max 2MB)
        if ($_FILES["foto"]["size"] > 2000000) {
            $error_message = "Sorry, your file is too large.";
        }

        // Allow certain file formats
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($imageFileType, $allowed_extensions)) {
            $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        if (!isset($error_message)) {
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                // Update with photo
                $update_query = "UPDATE Makanan SET namamakanan = ?, harga = ?, deskripsi = ?, stok = ?, foto = ? WHERE idmakanan = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("sssisi", $namamakanan, $harga, $deskripsi, $stok, $foto, $idmakanan);
                $stmt->execute();
                header("Location: crudmakanan.php");
                exit;
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update without photo
        $update_query = "UPDATE Makanan SET namamakanan = ?, harga = ?, deskripsi = ?, stok = ? WHERE idmakanan = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssii", $namamakanan, $harga, $deskripsi, $stok, $idmakanan);
        $stmt->execute();
        header("Location: crudmakanan.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Makanan</title>
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
                        <a class="nav-link" href="crudmakanan.php">Makanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Edit Makanan</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="namamakanan" class="form-label">Nama Makanan</label>
                <input type="text" name="namamakanan" class="form-control" value="<?php echo $product['namamakanan']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" name="harga" class="form-control" value="<?php echo $product['harga']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="5" required><?php echo $product['deskripsi']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="<?php echo $product['stok']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Makanan</label><br>
                <img src="../assets/images/<?php echo $product['foto']; ?>" alt="Foto Makanan" width="150"><br><br>
                <input type="file" name="foto" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Perbarui Makanan</button>
        </form>
        <br>
        <br>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>