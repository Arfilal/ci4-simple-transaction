<?php namespace App\Controllers;

use App\Models\Pengembalian_Model;
use App\Models\Produk_Model;
use App\Models\Transaksi_Item_Model;
use CodeIgniter\Controller;

class Admin extends Controller
{
    // Tampilkan daftar semua permintaan retur
    public function pengembalian()
    {
        $pengembalianModel = new Pengembalian_Model();
        $data['retur'] = $pengembalianModel->orderBy('id', 'desc')->findAll();
        $data['title'] = 'Manajemen Pengembalian (Admin)';
        return view('admin/pengembalian', $data);
    }

    // Proses perubahan status retur
    public function proses_pengembalian($id)
    {
        $db = \Config\Database::connect();
        $db->transStart(); // Mulai transaksi

        $pengembalianModel = new Pengembalian_Model();
        $transaksiItemModel = new Transaksi_Item_Model();
        $produkModel = new Produk_Model();

        try {
            $retur = $pengembalianModel->find($id);

            if ($retur['status'] == 'selesai') {
                $db->transRollback(); // Batalkan transaksi
                return redirect()->back()->with('error', 'Pengembalian sudah selesai.');
            }

            // Update status retur
            $pengembalianModel->update($id, ['status' => 'selesai']);

            // Update jumlah dikembalikan di transaksi_item
            $transaksi_item = $transaksiItemModel->find($retur['transaksi_item_id']);
            $jumlah_retur = $retur['jumlah'];
            $transaksiItemModel->update($transaksi_item['id'], ['jumlah_dikembalikan' => $transaksi_item['jumlah_dikembalikan'] + $jumlah_retur]);
            
            // Tambah stok produk
            $produk = $produkModel->find($transaksi_item['produk_id']);
            $produkModel->update($produk['id'], ['stok' => $produk['stok'] + $jumlah_retur]);

            $db->transComplete(); // Selesaikan transaksi

            if ($db->transStatus() === false) {
                // Transaksi gagal, kembalikan dengan pesan error
                return redirect()->back()->with('error', 'Gagal memproses pengembalian.');
            }

        } catch (\Exception $e) {
            $db->transRollback(); // Batalkan transaksi jika terjadi error
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pengembalian berhasil diproses.');
    }
}