<?php
include 'db/connection.php';

// Fetch makanan
$product_query = "SELECT * FROM Makanan LIMIT 4";
$product_result = $conn->query($product_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makanan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Custom CSS */
    .hero-section {
        background: url('assets/images/hero-image.jpg') no-repeat center center;
        background-size: cover;
        height: 100vh;
        color: white;
    }

    .hero-section {
        /* ... gaya Anda ... */
        border: 2px solid red;
        /* Tambahkan ini untuk debugging */
    }

    .hero-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-top: 30px;
    }

    .card-img-top {
        object-fit: cover;
        height: 200px;
    }

    .footer {
        background-color: #f8f9fa;
        padding: 20px;
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Makanan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak">Makanan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center justify-content-center text-white"
        style="position: relative; height: 100vh; background: url('assets/images/bg-hero.jpg') no-repeat center center; background-size: cover;">
        <div style="position: absolute; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.5);">
        </div>
        <div class="container text-center position-relative" style="z-index: 2;">
            <h1>Selamat Datang di Website Makanan</h1>
            <p></p>
            <a href="makanan.php" class="btn btn-primary btn-lg">Lihat Makanan</a>
        </div>
    </section>

    <!-- Home Section -->
    <section id="home" class="container mt-5 d-none">
        <h2 class="text-center section-title">Home</h2>
        <p class="text-center">Selamat datang di Website Makanan</p>
    </section>

    <section id="katalog" class="container mt-5 d-none">
        <h2 class="text-center section-title">Makanan</h2>
        <div class="row">
            <?php while ($product = $product_result->fetch_assoc()): ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="assets/images/<?= htmlspecialchars($product['foto']) ?>" class="card-img-top"
                        alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['namamakanan']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product['deskripsi']) ?></p>
                        <a href="makanandetail.php?id=<?= $product['idmakanan'] ?>" class="btn btn-primary">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-3">
            <a href="makanan.php" class="btn btn-primary btn-lg">Lihat Semua Makanan</a>
        </div>
    </section>
    <style>
    .card-img-top:hover {
        transform: scale(1.1);
    }

    .overlay {
        transition: opacity 0.3s ease;
    }

    .position-relative:hover .overlay {
        opacity: 1 !important;
    }
    </style>

    <?php include 'makanan.php'
    ?>


    <!-- Contact Section -->
    <section id="kontak" class="container mt-5 d-flex">
        <h2 class="text-center section-title">Contact Information</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="row g-0">
                        <!-- Profile Image -->
                        <div class="col-md-4">
                            <img src="assets/images/profil.jpeg" class="img-fluid rounded-start" alt="Profile Image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Fadilah rizky darwin</h5>
                                <p class="card-text"><strong>Phone:</strong> 0895 3764 31178</p>
                                <p class="card-text"><strong>Email:</strong> fadilahrizky339@gmail.com</p>
                                <p class="card-text"><strong>Address:</strong> Kp Rambutan Ciracas Jakarta Timur</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <section class="footer text-center py-4">
        <p>&copy; 2025 My Makanan. All rights reserved.</p>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>