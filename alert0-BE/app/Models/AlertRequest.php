<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertRequest  extends Model
{
    use HasFactory;



         /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $fillable = [
        'user_id', 'request_type', 'request_status', 'request_date', 'longitude', 'latitude', 'request_photo'
        ];
}
