<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\Traits\LogsActivity;


class Gialieu extends Pivot
{
    use LogsActivity;

    protected $table = 'gialieus';
    public $timestamps = null;

    // protected $fillable = [
    //     'ct_id', 'vattu_id', 'tyle','stt'
    // ];

    protected static $logAttributes = ['ct_id', 'vattu_id', 'tyle','stt'];
    //protected static $logOnlyDirty = true;

}
