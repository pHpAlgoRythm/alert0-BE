<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class response extends Model
{
    use HasFactory;
    
    protected $table = 'response';

    protected $fillable = [
       'request_id',
       'responders_id',
       'drivers_id',
       'status',
       'current_latitude',
       'current_longitude',
       'request_status',
       'drivers_response',
       'responders_response'
    ];

    public function alertRequest()
    {
        return $this->belongsTo(AlertRequest::class, 'request_id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responders_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'drivers_id');
    }
}
