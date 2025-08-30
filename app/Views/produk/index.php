<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>

    <h2>Daftar Produk</h2>
    <a href="<?= base_url('produk/create') ?>" class="btn btn-primary mb-3">Tambah Produk</a>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produk as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['nama_produk'] ?></td>
                    <td>Rp. <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td><?= $item['stok'] ?></td>
                    <td>
                        <a href="<?= base_url('produk/edit/' . $item['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= base_url('produk/delete/' . $item['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?= $this->endSection() ?>