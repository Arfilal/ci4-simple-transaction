<?php namespace App\Models;

use CodeIgniter\Model;

class Pengembalian_Model extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['transaksi_id', 'transaksi_item_id', 'jumlah', 'alasan', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}