<?php namespace App\Models;

use CodeIgniter\Model;

class Produk_Model extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['nama_produk', 'harga', 'stok'];

    // Menambahkan timestamp otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}