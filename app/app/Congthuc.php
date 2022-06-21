<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;


class Congthuc extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $primaryKey = 'id';
    protected $table = 'congthucs';
    public $incrementing = false;
    protected $keyType = 'string';



    protected $fillable = [
        'id','blend_id', 'sothongbao', 'ngay_thongbao','file'
    ];

    protected static $logAttributes = ['blend_id', 'sothongbao', 'ngay_thongbao','file'];
    //protected static $logOnlyDirty = true;

    public function blend()
    {
        return $this->belongsTo(Blend::class, 'blend_id')->withTrashed();
    }

    public function gialieus()
    {
        // return $this->belongsToMany(GLHL::class, 'gialieus', 'ct_id','vattu_id')->withPivot('tyle','stt');
        return $this->belongsToMany(GLHL::class, 'gialieus', 'ct_id','vattu_id')->using('App\Gialieu')->withPivot('tyle','stt');
    }

    public function huonglieus()
    {
        return $this->belongsToMany(GLHL::class, 'huonglieus', 'ct_id','vattu_id')->using('App\Huonglieu')->withPivot('tyle','stt');
    }
    public function logs()
    {
        return $this->hasMany(Xuat::class, 'ct_id');
    }

    
}
