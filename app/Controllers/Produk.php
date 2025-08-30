<?php namespace App\Controllers;

use App\Models\Produk_Model;
use CodeIgniter\Controller;

class Produk extends Controller
{
    // Tampilkan daftar semua produk (Read)
    public function index()
    {
        $model = new Produk_Model();
        $data['produk'] = $model->findAll();
        return view('produk/index', $data);
    }

    // Tampilkan form untuk menambah produk baru (Create - Form)
    public function create()
    {
        // Mendapatkan layanan validasi
        $data['validation'] = \Config\Services::validation();
        return view('produk/form_add', $data);
    }

    // Simpan data produk baru ke database (Create - Process)
    public function store()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'nama_produk' => 'required|min_length[3]',
            'harga'       => 'required|numeric|greater_than[0]',
            'stok'        => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke form dengan pesan error
            return view('produk/form_add', [
                'validation' => $this->validator
            ]);
        }

        // Jika validasi berhasil, simpan data ke database
        $model = new Produk_Model();
        $data = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
        ];
        $model->save($data);

        // Redirect ke halaman produk dengan pesan sukses
        return redirect()->to('/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Tampilkan form untuk mengedit produk (Update - Form)
    public function edit($id = null)
    {
        $model = new Produk_Model();
        $data['produk'] = $model->where('id', $id)->first();
        if (empty($data['produk'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }
        // Mendapatkan layanan validasi
        $data['validation'] = \Config\Services::validation();
        return view('produk/form_edit', $data);
    }

    // Proses update data produk (Update - Process)
    public function update()
    {
        // Menambahkan validasi untuk update
        $validation = \Config\Services::validation();
        $rules = [
            'nama_produk' => 'required|min_length[3]',
            'harga'       => 'required|numeric|greater_than[0]',
            'stok'        => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke form edit dengan pesan error
            $id = $this->request->getPost('id');
            $model = new Produk_Model();
            $data['produk'] = $model->find($id);
            $data['validation'] = $this->validator;
            return view('produk/form_edit', $data);
        }

        $model = new Produk_Model();
        $id = $this->request->getPost('id');
        $data = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
        ];
        $model->update($id, $data);
        return redirect()->to('/produk')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk dari database (Delete)
    public function delete($id = null)
    {
        $model = new Produk_Model();
        $model->delete($id);
        return redirect()->to('/produk')->with('success', 'Produk berhasil dihapus.');
    }
}