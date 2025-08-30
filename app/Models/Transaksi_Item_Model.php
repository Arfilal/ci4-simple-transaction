<?php namespace App\Models;

use CodeIgniter\Model;

class Transaksi_Item_Model extends Model
{
    protected $table = 'transaksi_item';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['transaksi_id', 'produk_id', 'jumlah', 'harga_satuan', 'jumlah_dikembalikan']; // Pastikan 'jumlah_dikembalikan' ada

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}