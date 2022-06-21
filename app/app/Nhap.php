<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;



class Nhap extends Model
{
    use SoftDeletes, LogsActivity;

    protected $primaryKey = 'id';
    protected $table = 'nhaps';
    public $incrementing = false;
    protected $keyType = 'string';



    protected $fillable = [
        'id','so_ct','ngay_nhap','user_id','lan'
    ];

    protected static $logAttributes = ['so_ct','ngay_nhap','user_id'];
    //protected static $logOnlyDirty = true;


    public function nhap_details()
    {
        return $this->hasMany(Nhap_detail::class, 'log_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($nhap) { // before delete() method call this
             
            if ($nhap->isForceDeleting()) {
                $nhap->nhap_details()->forceDelete();
            } else {
                $nhap->nhap_details()->delete();
            }
             // do the rest of the cleanup...
        });

        static::restoring(function($nhap) { // before delete() method call this
            $nhap->nhap_details()->withTrashed()->restore();
            // do the rest of the cleanup...
        });
    }

}
