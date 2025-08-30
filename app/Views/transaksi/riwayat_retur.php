<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>

    <h2>Riwayat Pengembalian Barang</h2>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Transaksi ID</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($retur as $r): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= $r['transaksi_id'] ?></td>
                    <td>
                        <?php
                            $transaksiItemModel = new \App\Models\Transaksi_Item_Model();
                            $produkModel = new \App\Models\Produk_Model();
                            $item = $transaksiItemModel->find($r['transaksi_item_id']);
                            $produk = $produkModel->find($item['produk_id']);
                            echo $produk['nama_produk'];
                        ?>
                    </td>
                    <td><?= $r['jumlah'] ?></td>
                    <td>
                        <span class="badge bg-<?= $r['status'] == 'selesai' ? 'success' : 'warning' ?>">
                            <?= ucfirst($r['status']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <?php if (empty($retur)): ?>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-center">Belum ada riwayat pengembalian.</td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>

<?= $this->endSection() ?>