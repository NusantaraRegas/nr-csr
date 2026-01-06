<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewPembayaran extends Model
{
    protected $table = 'V_PEMBAYARAN'; // nama view sesuai di database
    protected $primaryKey = 'ID_PEMBAYARAN'; // jika ada primary key, walaupun view

    public $incrementing = false; // disable auto-increment jika ID dari view tidak otomatis
    public $timestamps = false; // karena view biasanya tidak punya created_at & updated_at

    protected $guarded = []; // biar bisa mass-assignment kalau dibutuhkan

    // Contoh relasi opsional jika kamu ingin buat relasi ke model Kelayakan
    public function kelayakan()
    {
        return $this->belongsTo(Kelayakan::class, 'ID_KELAYAKAN', 'id_kelayakan');
    }

    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class, 'ID_LEMBAGA', 'id_lembaga');
    }

    public function proker()
    {
        return $this->belongsTo(Proker::class, 'ID_PROKER', 'id_proker');
    }
}
