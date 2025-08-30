<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Transaksi_Model;
use App\Models\Produk_Model;
use App\Models\Transaksi_Item_Model;

class XenditCallback extends Controller
{
    public function invoicePaid()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        // Verifikasi bahwa payload adalah notifikasi faktur
        if (isset($data['external_id']) && isset($data['status'])) {
            $xenditId = $data['id'] ?? null;
            $externalId = $data['external_id'];
            $status = $data['status'];

            // Ambil ID transaksi dari external_id
            $transaksiId = str_replace('transaksi-', '', $externalId);
            $transaksiModel = new Transaksi_Model();

            // Cek apakah status PAID atau EXPIRED
            if ($status === 'PAID') {
                // Proses pembayaran sukses
                $transaksiModel->update($transaksiId, ['status' => $status, 'xendit_id' => $xenditId]);

                // Kurangi stok produk jika pembayaran berhasil
                $transaksiItemModel = new Transaksi_Item_Model();
                $produkModel = new Produk_Model();
                $items = $transaksiItemModel->where('transaksi_id', $transaksiId)->findAll();
                foreach ($items as $item) {
                    $produk = $produkModel->find($item['produk_id']);
                    $newStok = $produk['stok'] - $item['jumlah'];
                    $produkModel->update($item['produk_id'], ['stok' => $newStok]);
                }
            } elseif ($status === 'EXPIRED') {
                // Proses pembayaran kadaluwarsa
                $transaksiModel->update($transaksiId, ['status' => $status, 'xendit_id' => $xenditId]);
            }
            
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Webhook received successfully.']);
        }
        
        return $this->response->setStatusCode(400)->setJSON(['message' => 'Invalid webhook data']);
    }
}