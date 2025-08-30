<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>

    <h2>Tambah Produk Baru</h2>
    <form action="<?= base_url('produk/store') ?>" method="post">
        
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= old('nama_produk') ?>" required>
            <?php if ($validation->hasError('nama_produk')): ?>
                <div class="text-danger mt-2">
                    <?= $validation->getError('nama_produk') ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="<?= old('harga') ?>" required>
            <?php if ($validation->hasError('harga')): ?>
                <div class="text-danger mt-2">
                    <?= $validation->getError('harga') ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" value="<?= old('stok') ?>" required>
            <?php if ($validation->hasError('stok')): ?>
                <div class="text-danger mt-2">
                    <?= $validation->getError('stok') ?>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('produk') ?>" class="btn btn-secondary">Batal</a>
    </form>

<?= $this->endSection() ?>