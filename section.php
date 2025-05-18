<?php
include 'db/connection.php';

// Fetch all portofolio data from the database
$portofolio_query = "SELECT namaportofolio, deskripsi, foto, tahunmulai, tahunakhir FROM  makanan  ";
$portofolio_result = $conn->query($portofolio_query);
?>

<style>
.card-hover {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

/* Pilihan Background */
.bg-light-cream {
    background-color: #f8f9fa;
    /* Light Cream */
}

.bg-soft-blue {
    background-color: #e9ecef;
    /* Soft Blue-Gray */
}

.bg-light-grey {
    background-color: #f2f2f2;
    /* Light Grey */
}

.bg-white-smoke {
    background-color: #f5f5f5;
    /* White Smoke */
}
</style>

<section class="bg-light-cream py-5" id="portofolio">
    <div class="container">
        <h2 class="text-center mb-4">Portofolio</h2>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            if ($portofolio_result->num_rows > 0) {
                while ($portofolio = $portofolio_result->fetch_assoc()) {
                    echo '<div class="col">';
                    echo '<div class="card h-100 shadow-sm card-hover">';
                    echo '<img src="assets/images/' . htmlspecialchars($portofolio['foto']) . '" class="card-img-top" alt="' . htmlspecialchars($portofolio['namaportofolio']) . '" style="object-fit: cover; height: 250px;">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($portofolio['namaportofolio']) . '</h5>';
                    echo '<p class="card-text text-muted">' . htmlspecialchars($portofolio['deskripsi']) . '</p>';
                    echo '<p class="card-text"><small class="text-muted">Tahun: ' . htmlspecialchars($portofolio['tahunmulai']);
                    if (!empty($portofolio['tahunakhir'])) {
                        echo ' - ' . htmlspecialchars($portofolio['tahunakhir']);
                    }
                    echo '</small></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col"><p class="text-center">Tidak ada portofolio yang ditampilkan.</p></div>';
            }
            ?>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>