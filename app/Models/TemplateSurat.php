<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model
{

    protected $table = "template_surat";
    public $timestamps = true;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function admin()
    {
        return $this->belongsTo('App\Models\UserModel', 'admin_id', 'id');
    }

    public function TemplateSuratDetails()
    {
        return $this->hasMany(TemplateSuratDetail::class);
    }

    public function surat()
    {
        return $this->belongsTo('App\Models\Surat', 'id', 'template_surat_id');
    }
}
