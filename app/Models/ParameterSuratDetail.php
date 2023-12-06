<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterSuratDetail extends Model
{

    protected $table = "parameter_surat_detail";
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function parent()
    {
        return $this->belongsTo('App\Models\ParameterSurat', 'parameter_surat_id', 'id');
    }
}