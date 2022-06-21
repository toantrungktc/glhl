<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;



class Blend extends Model
{
    use SoftDeletes, LogsActivity;

    protected $primaryKey = 'id';
    protected $table = 'blends';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $dates = ['deleted_at']; 

    protected $fillable = [
        'id','name'
    ];

    protected static $logAttributes = ['name'];

    public function congthucs()
    {
        return $this->hasMany(Congthuc::class, 'blend_id')->withTrashed();
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($blend) { // before delete() method call this
            //$blend->congthucs()->delete();
            if ($blend->isForceDeleting()) {
                $blend->congthucs()->forceDelete();
            } else {
                $blend->congthucs()->delete();
            }
             // do the rest of the cleanup...
        });

        static::restoring(function($blend) { // before delete() method call this
            $blend->congthucs()->withTrashed()->restore();
            // do the rest of the cleanup...
        });
    }
}
