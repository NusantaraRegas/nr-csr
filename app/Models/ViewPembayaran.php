<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewPembayaran extends Model
{
    protected $table = 'v_pembayaran'; // nama view sesuai di database
    protected $primaryKey = 'id_pembayaran'; // jika ada primary key, walaupun view

    public $incrementing = false; // disable auto-increment jika ID dari view tidak otomatis
    public $timestamps = false; // karena view biasanya tidak punya created_at & updated_at

    protected $guarded = []; // biar bisa mass-assignment kalau dibutuhkan

    // Contoh relasi opsional jika kamu ingin buat relasi ke model Kelayakan
    public function kelayakan()
    {
        return $this->belongsTo(Kelayakan::class, 'id_kelayakan', 'id_kelayakan');
    }

    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class, 'id_lembaga', 'id_lembaga');
    }

    public function proker()
    {
        return $this->belongsTo(Proker::class, 'id_proker', 'id_proker');
    }
}
