<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #343a40;
        }

        .contact-card {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            transition: transform 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .profile-img {
            object-fit: cover;
            height: 100%;
            width: 100%;
            border-radius: 0;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.5rem;
            color: #007bff;
        }

        .contact-info strong {
            color: #495057;
        }

        footer {
            margin-top: 50px;
            padding: 20px 0;
            color: #6c757d;
            font-size: 0.9rem;
        }

        @media (max-width: 576px) {
            .contact-card .row>div {
                padding: 0 !important;
            }

            .profile-img {
                height: 200px;
                border-radius: 12px 12px 0 0;
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
                    <li class="nav-item"><a class="nav-link" href="makanan.php">Makanan</a></li>

                    <li class="nav-item"><a class="nav-link active" href="kontak.php">Kontak</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Informasi Kontak</h2>

        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="contact-card">
                    <div class="row g-0">
                        <!-- Profile Image -->
                        <div class="col-md-4 col-12">
                            <img src="assets/images/profil.jpeg" class="profile-img img-fluid" alt="Profile Image">
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="card-body contact-info p-4">
                                <h5 class="card-title">Fadilah Rizky Darwin</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 100px;">No. HP</th>
                                        <td>0895 3764 31178</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>fadilahrizky339@gmail.com</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>Kp Rambutan, Ciracas, Jakarta Timur</td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="text-center">
            <p>Untuk informasi lebih lanjut, jangan ragu untuk menghubungi kami melalui rincian di atas.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>