<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;



class Nhap_detail extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $primaryKey = 'id';
    protected $table = 'nhap_details';

    protected $fillable = [
        'log_id', 'vattu_id', 'khoiluong'
    ];

    protected static $logAttributes = ['log_id', 'vattu_id', 'khoiluong'];


    protected $touches = ['nhap'];

    public function nhap()
    {
        return $this->belongsTo(Nhap::class, 'log_id');
    }

    public function glhl()
    {
        return $this->belongsTo(GLHL::class, 'vattu_id');
    }
}
