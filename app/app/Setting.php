<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
        
   
    protected $primaryKey = 'id';
    protected $table = 'settings';
    //public $incrementing = false;
    // protected $dates = ['deleted_at'];

    protected $fillable = [
         'daily','monthly'
    ];
}
