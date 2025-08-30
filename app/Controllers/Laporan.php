<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Laporan extends Controller
{
    public function index($mode = 'harian')
    {
        $db = \Config\Database::connect();
        $data['mode'] = $mode;

        switch ($mode) {
            case 'bulanan':
                $query = $db->query("
                    SELECT 
                        DATE_FORMAT(tanggal, '%Y-%m') as periode, 
                        SUM(total_harga) as total_penjualan
                    FROM transaksi
                    GROUP BY periode
                    ORDER BY periode DESC
                ");
                $data['laporan'] = $query->getResultArray();
                $data['title'] = 'Laporan Penjualan Bulanan';
                break;

            case 'per_produk':
                $query = $db->query("
                    SELECT 
                        p.nama_produk, 
                        SUM(ti.jumlah) as total_jumlah, 
                        SUM(ti.jumlah * ti.harga_satuan) as total_penjualan
                    FROM transaksi_item ti
                    JOIN produk p ON p.id = ti.produk_id
                    GROUP BY p.nama_produk
                    ORDER BY total_penjualan DESC
                ");
                $data['laporan'] = $query->getResultArray();
                $data['title'] = 'Laporan Penjualan Per Produk';
                break;
            
            case 'harian':
            default:
                $query = $db->query("
                    SELECT DATE(tanggal) as periode, SUM(total_harga) as total_penjualan
                    FROM transaksi
                    GROUP BY periode
                    ORDER BY periode DESC
                ");
                $data['laporan'] = $query->getResultArray();
                $data['title'] = 'Laporan Penjualan Harian';
                break;
        }

        return view('laporan/index', $data);
    }
}