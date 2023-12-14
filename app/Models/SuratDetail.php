<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratDetail extends Model
{

    protected $table = "surat_detail";
    public $timestamps = true;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function surat()
    {
        return $this->belongsTo('App\Models\Surat', 'surat_id', 'id');
    }
}