<?php
include 'db/connection.php';

// Fetch makanan
$product_query = "SELECT * FROM Makanan LIMIT 4";
$product_result = $conn->query($product_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Toko Olahraga</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=PT+Serif:wght@400;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="lib/animate/animate.min.css" rel="stylesheet">

    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

</head>

<body>

    <div class="container-fluid sticky-top px-0 fixed-top">
        <div class="container-fluid bg-light">
            <div class="container px-0">
                <nav class="navbar navbar-light navbar-expand-xl">
                    <a href="index.html" class="navbar-brand d-flex align-items-center">
                        <i class='bx bx-briefcase bx-lg text-primary me-2'></i>
                        <h1 class="text-primary display-6 mb-0">Portofolio</h1>
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-light py-3" id="navbarCollapse">
                        <div class="navbar-nav ms-auto border-top">
                            <a href="index.html" class="nav-item nav-link active">Home</a>
                            <a href="about.html" class="nav-item nav-link">Portofolio</a>
                            <a href="product.html" class="nav-item nav-link">Pendidikan</a>
                            <a href="signin.html" class="nav-item nav-link">Pekerjaan</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid carousel-header px-0">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img src="assets/images/bakso.jpg" class="img-fluid" alt="Keindahan Karimun Jawa">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-primary text-uppercase mb-3">Toko Olahraga</h4>
                            <h1 class="display-1 text-capitalize text-dark mb-3">Menjual Perlengkapan Olahraga</h1>
                            <p class="mx-md-5 fs-4 px-4 mb-5 text-dark">Termurah dan Terjangkau</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5"
                                    href="#about">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/bg2.jpg" class="img-fluid" alt="Snorkeling di Karimun Jawa">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-primary text-uppercase mb-3">Toko Olahraga</h4>
                            <h1 class="display-1 text-capitalize text-dark mb-3">Menjual Perlengkapan Olahraga</h1>
                            <p class="mx-md-5 fs-4 px-4 mb-5 text-dark">Termurah dan Terjangkau</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5"
                                    href="#about">Learn More</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/bg3.jpg" class="img-fluid" alt="Sunset di Karimun Jawa">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-primary text-uppercase mb-3">Toko Olahraga</h4>
                            <h1 class="display-1 text-capitalize text-dark mb-3">Menjual Perlengkapan Olahraga</h1>
                            <p class="mx-md-5 fs-4 px-4 mb-5 text-dark">Termurah dan Terjangkau</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5"
                                    href="#about">Learn More</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>