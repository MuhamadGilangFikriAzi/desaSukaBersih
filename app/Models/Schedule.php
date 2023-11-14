<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{

    protected $table = 'surat';
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    public function parameterSurat()
    {
        return $this->hasOne('App\parameter_surat', 'parameter_surat', 'id');
    }
}