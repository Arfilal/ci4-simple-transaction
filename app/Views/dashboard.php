<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>

    <h2 class="mb-4">Dashboard</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Produk</h5>
                            <h2 class="card-text"><?= $total_produk ?></h2>
                        </div>
                        <i class="fa-solid fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Transaksi</h5>
                            <h2 class="card-text"><?= $total_transaksi ?></h2>
                        </div>
                        <i class="fa-solid fa-receipt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Pendapatan</h5>
                            <h2 class="card-text">Rp. <?= number_format($total_pendapatan, 0, ',', '.') ?></h2>
                        </div>
                        <i class="fa-solid fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<?= $this->endSection() ?>