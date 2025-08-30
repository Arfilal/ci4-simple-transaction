<?php namespace App\Models;

use CodeIgniter\Model;

class Transaksi_Model extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    // Pastikan 'status' dan 'xendit_id' sudah ada di sini
    protected $allowedFields = ['tanggal', 'total_harga', 'status', 'xendit_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}