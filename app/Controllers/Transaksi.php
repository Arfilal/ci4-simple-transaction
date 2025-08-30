<?php namespace App\Controllers;

use App\Models\Produk_Model;
use App\Models\Transaksi_Model;
use App\Models\Transaksi_Item_Model;
use App\Models\Pengembalian_Model;
use CodeIgniter\Controller;

class Transaksi extends Controller
{
    // Tampilkan halaman transaksi dengan daftar produk
    public function index()
    {
        $produkModel = new Produk_Model();
        $data['produk'] = $produkModel->findAll();
        return view('transaksi/index', $data);
    }

    // Proses penyimpanan transaksi
    public function store()
{
    $db = \Config\Database::connect();
    $db->transStart();

    try {
        $transaksiModel = new \App\Models\Transaksi_Model();
        $transaksiItemModel = new \App\Models\Transaksi_Item_Model();
        $produkModel = new \App\Models\Produk_Model();

        $cart = $this->request->getPost('cart');
        $totalHarga = 0;

        if (!$cart) {
            return redirect()->to('/transaksi')->with('error', 'Keranjang belanja kosong.');
        }

        $transaksiItemsData = [];
        foreach ($cart as $produkId => $item) {
            if ($item['jumlah'] > 0) {
                $produk = $produkModel->find($produkId);
                if ($item['jumlah'] > $produk['stok']) {
                    $db->transRollback();
                    return redirect()->to('/transaksi')->with('error', 'Stok produk ' . $produk['nama_produk'] . ' tidak mencukupi.');
                }
                $totalHarga += $produk['harga'] * $item['jumlah'];
                
                $transaksiItemsData[] = [
                    'produk_id' => $produkId,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $produk['harga'],
                ];
            }
        }

        // Simpan data transaksi
        if (empty($transaksiItemsData)) {
            $db->transRollback();
            return redirect()->to('/transaksi')->with('error', 'Keranjang belanja kosong.');
        }

        $transaksiData = [
            'tanggal'     => date('Y-m-d H:i:s'),
            'total_harga' => $totalHarga,
        ];
        $transaksiModel->save($transaksiData);
        $transaksiId = $transaksiModel->getInsertID();

        // Simpan detail produk dan kurangi stok
        foreach ($transaksiItemsData as $item) {
            $item['transaksi_id'] = $transaksiId;
            $transaksiItemModel->save($item);

            $produk = $produkModel->find($item['produk_id']);
            $newStok = $produk['stok'] - $item['jumlah'];
            $produkModel->update($item['produk_id'], ['stok' => $newStok]);
        }

        $db->transComplete();

    } catch (\Exception $e) {
        $db->transRollback();
        return redirect()->to('/transaksi')->with('error', 'Transaksi gagal: ' . $e->getMessage());
    }

    if ($db->transStatus() === false) {
        return redirect()->to('/transaksi')->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
    }

    return redirect()->to('/transaksi/history')->with('success', 'Transaksi berhasil disimpan!');
}

    // Tampilkan riwayat semua transaksi
    public function history()
    {
        $transaksiModel = new Transaksi_Model();
        $data['transaksi'] = $transaksiModel->orderBy('id', 'desc')->findAll();
        return view('transaksi/history', $data);
    }

    // Tampilkan detail transaksi
    public function detail($id = null)
    {
        $transaksiModel = new Transaksi_Model();
        $transaksiItemModel = new Transaksi_Item_Model();
        $produkModel = new Produk_Model();

        $data['transaksi'] = $transaksiModel->find($id);
        $items = $transaksiItemModel->where('transaksi_id', $id)->findAll();

        foreach ($items as &$item) {
            $produk = $produkModel->find($item['produk_id']);
            $item['nama_produk'] = $produk['nama_produk'];
        }
        $data['items'] = $items;

        return view('transaksi/detail', $data);
    }

    // Tampilkan form pengembalian
    public function retur($transaksi_id, $transaksi_item_id)
    {
        $transaksiItemModel = new \App\Models\Transaksi_Item_Model();
        $produkModel = new \App\Models\Produk_Model();

        $item = $transaksiItemModel->find($transaksi_item_id);
        if (empty($item)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Item transaksi tidak ditemukan.');
        }

        $produk = $produkModel->find($item['produk_id']);

        $data = [
            'transaksi_id'      => $transaksi_id,
            'transaksi_item_id' => $transaksi_item_id,
            'item'              => $item,
            'produk'            => $produk,
            'title'             => 'Formulir Pengembalian',
        ];

        return view('transaksi/form_retur', $data);
    }

    // Proses pengembalian barang
    public function proses_retur()
    {
        $pengembalianModel = new \App\Models\Pengembalian_Model();
        $transaksiItemModel = new \App\Models\Transaksi_Item_Model();

        $id_item = $this->request->getPost('transaksi_item_id');
        $jumlah_retur = $this->request->getPost('jumlah');
        $alasan = $this->request->getPost('alasan');

        $item = $transaksiItemModel->find($id_item);

        if ($jumlah_retur <= 0 || ($item['jumlah'] - $item['jumlah_dikembalikan']) < $jumlah_retur) {
            return redirect()->back()->with('error', 'Jumlah retur tidak valid.');
        }

        $pengembalianModel->save([
            'transaksi_id'      => $this->request->getPost('transaksi_id'),
            'transaksi_item_id' => $id_item,
            'jumlah'            => $jumlah_retur,
            'alasan'            => $alasan,
        ]);

        return redirect()->to('/transaksi/history')->with('success', 'Permintaan retur berhasil diajukan.');
    }

    // Tampilkan riwayat pengembalian untuk konsumen
    public function riwayat_retur()
    {
        $pengembalianModel = new \App\Models\Pengembalian_Model();
        $data['retur'] = $pengembalianModel->orderBy('id', 'desc')->findAll();
        $data['title'] = 'Riwayat Pengembalian';
        return view('transaksi/riwayat_retur', $data);
    }
}