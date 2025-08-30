<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>

    <h2>Transaksi Baru</h2>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('transaksi/store') ?>" method="post">
        <div class="row">
            <div class="col-md-8">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Jumlah Beli</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produk as $item): ?>
                            <tr>
                                <td><?= $item['nama_produk'] ?></td>
                                <td>Rp. <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                <td><?= $item['stok'] ?></td>
                                <td>
                                    <input type="number" name="cart[<?= $item['id'] ?>][jumlah]" class="form-control" value="0" min="0" max="<?= $item['stok'] ?>" data-harga="<?= $item['harga'] ?>">
                                    <input type="hidden" name="cart[<?= $item['id'] ?>][id]" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="cart[<?= $item['id'] ?>][harga]" value="<?= $item['harga'] ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Transaksi</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <b>Total:</b>
                            <h4 class="text-primary" id="total_harga">Rp. 0</h4>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success w-100">Bayar</button>
                        <a href="<?= base_url('transaksi/history') ?>" class="btn btn-secondary w-100 mt-2">Lihat Riwayat</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const totalHargaElement = document.getElementById('total_harga');

            form.addEventListener('change', function(e) {
                if (e.target.type === 'number') {
                    let total = 0;
                    const inputs = form.querySelectorAll('input[type="number"]');
                    inputs.forEach(input => {
                        const harga = parseFloat(input.getAttribute('data-harga'));
                        const jumlah = parseInt(input.value);
                        if (!isNaN(harga) && !isNaN(jumlah)) {
                            total += harga * jumlah;
                        }
                    });
                    totalHargaElement.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(total)}`;
                }
            });
        });
    </script>

<?= $this->endSection() ?>