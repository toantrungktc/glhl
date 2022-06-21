<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Xuat_detail extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'xuat_details';
    // public $incrementing = false;
    // protected $keyType = 'string';



    protected $fillable = [
        'log_id', 'loai_vt','vattu_id', 'tyle', 'khoiluong'
    ];

    public function xuat()
    {
        return $this->belongsTo(Xuat::class, 'log_id');
    }

    public function glhl()
    {
        return $this->belongsTo(GLHL::class, 'vattu_id');
    }
}
