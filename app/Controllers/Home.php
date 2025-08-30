<?php namespace App\Controllers;

use App\Models\Produk_Model;
use App\Models\Transaksi_Model;
use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        $produkModel = new Produk_Model();
        $transaksiModel = new Transaksi_Model();

        $data['total_produk'] = $produkModel->countAll();
        $data['total_transaksi'] = $transaksiModel->countAll();
        $data['total_pendapatan'] = $transaksiModel->selectSum('total_harga')->first()['total_harga'];

        $data['title'] = 'Dashboard';
        return view('dashboard', $data);
    }
}