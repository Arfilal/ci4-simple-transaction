<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>

    <h2>Manajemen Pengembalian (Admin)</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Transaksi ID</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Alasan</th>
                <th>Status</th>
                <th>Aksi</th>
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
                    <td><?= $r['alasan'] ?></td>
                    <td>
                        <span class="badge bg-<?= $r['status'] == 'selesai' ? 'success' : 'warning' ?>">
                            <?= ucfirst($r['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($r['status'] == 'proses'): ?>
                            <a href="<?= base_url('admin/pengembalian/' . $r['id'] . '/proses') ?>" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin memproses pengembalian ini?')">Proses</a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled>Selesai</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <?php if (empty($retur)): ?>
            <tfoot>
                <tr>
                    <td colspan="7" class="text-center">Belum ada permintaan pengembalian.</td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>

<?= $this->endSection() ?>