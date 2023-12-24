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

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\SuratDetail', 'surat_id');
    }

    public function template_surat()
    {
        return $this->hasOne('App\Models\TemplateSurat', 'id', 'template_surat_id');
    }
}
