<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>

    <h2>Detail Transaksi</h2>
    <a href="<?= base_url('transaksi/history') ?>" class="btn btn-secondary mb-3">Kembali ke Riwayat</a>
    
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Transaksi ID: <?= $transaksi['id'] ?></h5>
            <p><strong>Tanggal:</strong> <?= $transaksi['tanggal'] ?></p>
            <p><strong>Total Harga:</strong> Rp. <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></p>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga Satuan</th>
                <th>Jumlah Beli</th>
                <th>Jumlah Retur</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item['nama_produk'] ?></td>
                    <td>Rp. <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                    <td><?= $item['jumlah'] ?></td>
                    <td><?= $item['jumlah_dikembalikan'] ?></td>
                    <td>Rp. <?= number_format($item['harga_satuan'] * $item['jumlah'], 0, ',', '.') ?></td>
                    <td>
                        <?php if ($item['jumlah_dikembalikan'] < $item['jumlah']): ?>
                            <a href="<?= base_url('transaksi/retur/' . $transaksi['id'] . '/' . $item['id']) ?>" class="btn btn-warning btn-sm">Ajukan Retur</a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled>Sudah Diretur</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?= $this->endSection() ?>