<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;


class Xuat extends Model
{
    use SoftDeletes, LogsActivity;

    protected $primaryKey = 'id';
    protected $table = 'xuats';
    public $incrementing = false;
    protected $keyType = 'string';



    protected $fillable = [
        'id','ngay_pha', 'ct_id2', 'kl_la', 'kl_gialieu', 'kl_thung_gl', 'kl_soi', 'kl_huonglieu', 'kl_thung_hl', 'user_id'
    ];

    protected static $logAttributes = ['ngay_pha', 'ct_id2', 'kl_la', 'kl_gialieu', 'kl_thung_gl', 'kl_soi', 'kl_huonglieu', 'kl_thung_hl', 'user_id'];

    public function congthuc()
    {
        return $this->belongsTo(Congthuc::class, 'ct_id2');
    }

    public function details()
    {
        return $this->hasMany(Xuat_detail::class, 'log_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($xuat) { // before delete() method call this
            $xuat->details()->delete();
             // do the rest of the cleanup...
        });

        static::restoring(function($xuat) { // before delete() method call this
            $xuat->details()->withTrashed()->restore();
            // do the rest of the cleanup...
        });
    }

    
}
