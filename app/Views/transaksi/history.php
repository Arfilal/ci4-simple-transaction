<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>

    <h2>Riwayat Transaksi</h2>
    <a href="<?= base_url('transaksi') ?>" class="btn btn-primary mb-3">Buat Transaksi Baru</a>
    <a href="<?= base_url('produk') ?>" class="btn btn-info mb-3">Manajemen Produk</a>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transaksi as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['tanggal'] ?></td>
                    <td>Rp. <?= number_format($item['total_harga'], 0, ',', '.') ?></td>
                    <td>
                        <a href="<?= base_url('transaksi/detail/' . $item['id']) ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?= $this->endSection() ?>