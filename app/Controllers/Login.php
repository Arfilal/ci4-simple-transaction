<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends Controller
{
    // Tampilkan form login
    public function index()
    {
        return view('login_form');
    }

    // Aksi untuk login sebagai Admin
    public function admin()
    {
        // Alihkan ke halaman admin
        return redirect()->to(base_url('produk'));
    }

    // Aksi untuk login sebagai Konsumen
    public function konsumen()
    {
        // Alihkan ke halaman konsumen
        return redirect()->to(base_url('transaksi'));
    }
}