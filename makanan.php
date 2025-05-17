<?php
include 'db/connection.php';

// Fetch all makanan
$product_query = "SELECT * FROM Makanan";
$product_result = $conn->query($product_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Makanan Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    body {
        background-color: #f8f9fa;
    }

    .product-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .product-title {
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 30px;
        color: #333;
    }

    .card-img-top {
        object-fit: cover;
        height: 200px;
        border-radius: 10px 10px 0 0;
    }

    .card {
        border: none;
        border-radius: 10px;
        transition: box-shadow 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 10px;
        color: #222;
    }

    .card-text {
        flex-grow: 1;
        color: #555;
        font-size: 1rem;
        margin-bottom: 15px;
    }

    .btn-primary {
        align-self: flex-start;
        font-weight: 600;
        padding: 8px 20px;
        font-size: 1rem;
        border-radius: 5px;
    }

    @media (max-width: 767px) {
        .product-container {
            margin: 20px 10px;
            padding: 15px;
        }

        .product-title {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.1rem;
        }

        .card-text {
            font-size: 0.95rem;
        }

        .btn-primary {
            font-size: 0.9rem;
            padding: 7px 16px;
        }
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Makanan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="makanan.php">Makanan</a></li>

                    <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="product-container">
        <h2 class="text-center product-title">Daftar Makanan</h2>
        <div class="row">
            <?php while ($product = $product_result->fetch_assoc()): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm rounded-3 overflow-hidden">
                    <img src="assets/images/<?= htmlspecialchars($product['foto']) ?>" class="card-img-top"
                        alt="<?= htmlspecialchars($product['namaportofolio']) ?>" />
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($product['namaportofolio']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product['deskripsi']) ?></p>
                        <a href="makanandetail.php?id=<?= $product['idportofolio'] ?>"
                            class="btn btn-primary mt-auto">View
                            Detail</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>