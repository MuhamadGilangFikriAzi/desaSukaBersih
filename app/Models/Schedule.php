<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $table = 'surat';
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    
}