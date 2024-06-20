<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css_perso/output/_formulaire.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="row">
    <?php foreach ($total as $t) { ?>
        <div class="col-lg-4">
            <a href="#">
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Montant devis total</h5>
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="fw-semibold mb-3"><?php echo number_format($t['total'], 2) ?> Ar</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
    <?php foreach ($paies as $p) { ?>
        <div class="col-lg-4">
            <a href="#">
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Total paiement effectué</h5>
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="fw-semibold mb-3"><?php echo number_format($p['total'], 2) ?> Ar</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
</div>

<div class="container">
    <div class="row justify-content-md-center">

        <label for="annee">Année</label>
        <form action="<?php echo site_url('BackController/load_page_tableau_de_bord'); ?>" method="post">
            <select id="annee" name="choixAnnee">
                <option value="2023">2021</option>
                <option value="2023">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
            </select>
            <button type="submit">Valider</button>
        </form>
        <br>
        <h2>Histogramme Mensuel</h2>
        <canvas id="monthlyChart"></canvas>

        <h2>Histogramme Annuel</h2>
        <canvas id="annualChart"></canvas>

        <script>
            const annualLabels = <?php echo json_encode(array_column($annee, 'annee')); ?>;
            const annualData = <?php echo json_encode(array_column($annee, 'total_annuel')); ?>;

            const annualCtx = document.getElementById('annualChart').getContext('2d');
            new Chart(annualCtx, {
                type: 'bar',
                data: {
                    labels: annualLabels,
                    datasets: [{
                        label: 'Total Annuel',
                        data: annualData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        barThickness: 30
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const monthlyLabels = <?php echo json_encode(array_column($mois, 'mois')); ?>;
            const monthlyData = <?php echo json_encode(array_column($mois, 'total_mensuel')); ?>;

            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Total Mensuel',
                        data: monthlyData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        barThickness: 30
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</div>