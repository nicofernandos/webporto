<?php
include 'db/connection.php';

$pekerjaan_query = "SELECT * FROM Pekerjaan";
$pekerjaan_result = $conn->query($pekerjaan_query);
?>

<section id="pekerjaan-section" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Pengalaman Kerja</h2>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php while ($pekerjaan = $pekerjaan_result->fetch_assoc()) : ?>
            <div class="col">
                <div class="card border-primary rounded-3 job-card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="assets/images/<?= htmlspecialchars($pekerjaan['fotopekerjaan']) ?>"
                                class="img-fluid rounded-start" alt="Logo Pekerjaan"
                                style="object-fit: contain; height: 150px; padding: 20px;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-2">
                                    <?=htmlspecialchars($pekerjaan['namapekerjaan']) ?> </h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <?= htmlspecialchars($pekerjaan['deskripsipekerjaan']) ?> </h6>
                                <div>
                                    <p class="card-text text-muted mb-1">
                                        Tahun: <?= htmlspecialchars($pekerjaan['tahunmulai']) ?>
                                        <?php if (!empty($pekerjaan['tahunakhir'])) : ?>
                                        - <?= htmlspecialchars($pekerjaan['tahunakhir']) ?>
                                        <?php else : ?>
                                        - Sekarang
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <!-- <p class="card-text text-muted text-wrap">
                                    <?= htmlspecialchars($pekerjaan['deskripsipekerjaan']) ?>
                                </p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>