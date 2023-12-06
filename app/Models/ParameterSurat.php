<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterSurat extends Model
{

    protected $table = "parameter_surat";
    public $timestamps = true;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function admin()
    {
        return $this->belongsTo('App\Models\UserModel', 'admin_id', 'id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\ParameterSuratDetail', 'parameter_surat_id', 'id');
    }
}
