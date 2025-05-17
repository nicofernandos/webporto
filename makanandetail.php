<?php
include 'db/connection.php';

// Get product ID from URL
$idmakanan = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$query = "SELECT * FROM Makanan WHERE idmakanan = $idmakanan";
$result = $conn->query($query);
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Product Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .product-detail-card {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .product-image {
            border-radius: 10px;
            object-fit: cover;
            width: 100%;
            height: 100%;
            max-height: 400px;
        }

        .product-info h2 {
            font-weight: 700;
            margin-bottom: 20px;
        }

        .product-price {
            font-size: 1.5rem;
            color: #28a745;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .product-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
        }

        @media (max-width: 767px) {
            .product-detail-card {
                padding: 20px;
                margin: 20px;
            }

            .product-price {
                font-size: 1.3rem;
            }

            .product-description {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <div class="product-detail-card">
        <div class="row g-4">
            <div class="col-md-6">
                <img src="assets/images/<?php echo htmlspecialchars($product['foto']); ?>" alt="Product Image" class="product-image" />
            </div>
            <div class="col-md-6 product-info d-flex flex-column justify-content-center">
                <h2><?php echo htmlspecialchars($product['namamakanan']); ?></h2>
                <div class="product-price">Rp <?php echo number_format($product['harga']); ?></div>
                <div class="product-description"><?php echo nl2br(htmlspecialchars($product['deskripsi'])); ?></div>
                <div class="mt-4">
                    <a href="makanan.php" class="btn btn-primary btn-lg">Kembali ke Makanan</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>