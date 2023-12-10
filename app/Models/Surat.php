<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{

    protected $table = "surat";
    public $timestamps = true;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function admin()
    {
        return $this->belongsTo('App\Models\UserModel', 'last_admin_print', 'id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\SuratDetail', 'surat_id');
    }

    public function parameter_surat()
    {
        return $this->hasOne('App\Models\ParameterSurat', 'id', 'parameter_surat_id');
    }
}
