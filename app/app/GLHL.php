<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;


class GLHL extends Model
{
    use SoftDeletes, LogsActivity;


    protected $primaryKey = 'id';
    protected $table = 'glhls';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'stt', 'name','code1','code2','dvt',
    ];

    public function congthuc_gl()
    {
        return $this->belongsToMany(Congthuc::class,  'gialieus', 'vattu_id','ct_id');
    }

    public function congthuc_hl()
    {
        return $this->belongsToMany(Congthuc::class,  'huonglieus', 'vattu_id','ct_id');
    }

    public function xuat_detail()
    {
        return $this->hasMany(Xuat_detail::class, 'vattu_id');
    }

    public function nhap_detail()
    {
        return $this->hasMany(Nhap_detail::class, 'vattu_id');
    }
}
