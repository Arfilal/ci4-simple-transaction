<?php namespace App\Controllers;

use CodeIgniter\Controller;
use Xendit\Xendit;

class CekXendit extends Controller
{
    public function index()
    {
        try {
            // Cek apakah class Xendit tersedia
            if (class_exists(Xendit::class)) {
                return "✅ Xendit class berhasil dikenali oleh autoload!";
            } else {
                return "❌ Xendit class TIDAK ditemukan.";
            }
        } catch (\Throwable $e) {
            return "⚠️ Error: " . $e->getMessage();
        }
    }
}
