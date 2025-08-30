<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center align-items-center" style="height: 70vh;">
    <div class="card" style="width: 25rem;">
        <div class="card-body text-center">
            <h5 class="card-title mb-4">Pilih Tipe Pengguna</h5>
            <div class="d-grid gap-2">
                <a href="<?= base_url('login/admin') ?>" class="btn btn-primary btn-lg">Masuk sebagai Admin</a>
                <a href="<?= base_url('login/konsumen') ?>" class="btn btn-secondary btn-lg">Masuk sebagai Konsumen</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>