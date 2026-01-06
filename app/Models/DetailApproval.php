<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailApproval extends Model
{
    protected $table = "tbl_detail_approval";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public $timestamps = false;

    public function kelayakan() {
        return $this->belongsTo(Kelayakan::class, 'id_kelayakan', 'id_kelayakan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function maker()
    {
        return $this->hasOne(User::class, 'id_user', 'created_by');
    }

    public function hirarki()
    {
        return $this->belongsTo(ViewHirarki::class, 'id_hirarki', 'id');
    }
}
