<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>

    <h2>Formulir Pengembalian Barang</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= $produk['nama_produk'] ?></h5>
            <p><strong>Harga Satuan:</strong> Rp. <?= number_format($item['harga_satuan'], 0, ',', '.') ?></p>
            <p><strong>Jumlah Beli:</strong> <?= $item['jumlah'] ?></p>
            <p><strong>Jumlah Tersisa untuk Diretur:</strong> <?= $item['jumlah'] - $item['jumlah_dikembalikan'] ?></p>
        </div>
    </div>

    <form action="<?= base_url('transaksi/proses-retur') ?>" method="post">
        <input type="hidden" name="transaksi_id" value="<?= $transaksi_id ?>">
        <input type="hidden" name="transaksi_item_id" value="<?= $transaksi_item_id ?>">
        
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Barang yang Dikembalikan</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" max="<?= $item['jumlah'] - $item['jumlah_dikembalikan'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="alasan" class="form-label">Alasan Pengembalian</label>
            <textarea class="form-control" id="alasan" name="alasan" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-danger">Ajukan Pengembalian</button>
        <a href="<?= base_url('transaksi/detail/' . $transaksi_id) ?>" class="btn btn-secondary">Batal</a>
    </form>

<?= $this->endSection() ?>