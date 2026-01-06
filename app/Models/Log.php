<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "TBL_LOG";
    protected $primaryKey = "ID";
    protected $guarded = ["ID"];

    public $timestamps = false;

    protected $casts = [
        'created_date' => 'datetime',
    ];

    // RELASI: setiap log milik satu user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
}
