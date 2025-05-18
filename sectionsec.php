<?php
include 'db/connection.php';

// Fetch all makanan
$pendidikan_query = "SELECT * FROM Pendidikan";
$pendidikan_result = $conn->query($pendidikan_query);
?>
<section id="pendidikan" class="py-5 bg-light shadow-xl">
    <div class="container">
        <h2 class="text-center mb-5">Pendidikan</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php while ($pendidikan = $pendidikan_result->fetch_assoc()) : ?>
            <div class="col">
                <div class="card h-100 shadow-sm card-hover">
                    <img src="assets/images/<?= htmlspecialchars($pendidikan['fotopendidikan']) ?>"
                        class="card-img-top img-fluid" alt="<?= htmlspecialchars($pendidikan['namapendidikan']) ?>"
                        style="object-fit: cover; height: 150px;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-center mb-2"><?= htmlspecialchars($pendidikan['namapendidikan']) ?>
                        </h5>
                        <p class="card-text text-muted text-truncate mb-3" style="height: 50px;">
                            <?= htmlspecialchars($pendidikan['deskripsipendidikan']) ?>
                        </p>
                        <div>
                            <p class="card-text small text-muted mb-1">
                                Tahun: <?= htmlspecialchars($pendidikan['tahunmulai']) ?>
                                <?php if (!empty($pendidikan['tahunakhir'])) : ?>
                                - <?= htmlspecialchars($pendidikan['tahunakhir']) ?>
                                <?php else : ?>
                                - Sekarang
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<style>
.card-hover {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}
</style>