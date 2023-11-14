<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterSurat extends Model
{

    protected $table = "parameter_surat";
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function admin()
    {
        return $this->belongsTo('App\Models\UserModel', 'admin_id', 'id');
    }
}
