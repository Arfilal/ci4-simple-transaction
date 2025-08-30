<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>

    <h2 class="mb-4"><?= $title ?></h2>

    <div class="mb-3">
        <a href="<?= base_url('laporan/harian') ?>" class="btn <?= $mode == 'harian' ? 'btn-primary' : 'btn-outline-primary' ?>">Harian</a>
        <a href="<?= base_url('laporan/bulanan') ?>" class="btn <?= $mode == 'bulanan' ? 'btn-primary' : 'btn-outline-primary' ?>">Bulanan</a>
        <a href="<?= base_url('laporan/per_produk') ?>" class="btn <?= $mode == 'per_produk' ? 'btn-primary' : 'btn-outline-primary' ?>">Per Produk</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <?php if ($mode == 'harian' || $mode == 'bulanan'): ?>
                    <th>Periode</th>
                    <th>Total Penjualan</th>
                <?php elseif ($mode == 'per_produk'): ?>
                    <th>Nama Produk</th>
                    <th>Jumlah Terjual</th>
                    <th>Total Penjualan</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($laporan)): ?>
                <tr>
                    <td colspan="<?= $mode == 'per_produk' ? 3 : 2 ?>" class="text-center">Belum ada data penjualan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($laporan as $row): ?>
                    <tr>
                        <?php if ($mode == 'harian' || $mode == 'bulanan'): ?>
                            <td><?= $row['periode'] ?></td>
                            <td>Rp. <?= number_format($row['total_penjualan'], 0, ',', '.') ?></td>
                        <?php elseif ($mode == 'per_produk'): ?>
                            <td><?= $row['nama_produk'] ?></td>
                            <td><?= $row['total_jumlah'] ?></td>
                            <td>Rp. <?= number_format($row['total_penjualan'], 0, ',', '.') ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (!empty($laporan)): ?>
        <hr>
        <h3 class="mb-4">Grafik Penjualan</h3>
        <div class="card p-3">
            <div style="width: 500px; margin: auto;">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const laporanData = <?= json_encode($laporan) ?>;

            if (laporanData.length > 0) {
                let labels = [];
                let dataValues = [];
                let chartType = '';
                let chartTitle = '';

                <?php if ($mode == 'harian' || $mode == 'bulanan'): ?>
                    laporanData.forEach(item => {
                        labels.push(item.periode);
                        dataValues.push(item.total_penjualan);
                    });
                    chartType = 'bar';
                    chartTitle = 'Total Penjualan per Periode';
                <?php elseif ($mode == 'per_produk'): ?>
                    laporanData.forEach(item => {
                        labels.push(item.nama_produk);
                        dataValues.push(item.total_penjualan);
                    });
                    chartType = 'pie';
                    chartTitle = 'Total Penjualan per Produk';
                <?php endif; ?>

                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: chartType,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: chartTitle,
                            data: dataValues,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Menambahkan ini untuk kontrol ukuran yang lebih baik
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>

<?= $this->endSection() ?>