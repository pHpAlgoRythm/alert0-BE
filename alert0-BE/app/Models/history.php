<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class history extends Model
{
  protected  $table = 'histories';

  protected $fillable = [

        'request_id',
        'response_id',
        'response_time',
        'site_arrival',
        'patient_contact',
        'site_departure',
        'hospital_arrival',
        'station_arrival',
        'vehicle_number',
  ];

  public function alertRequest()
  {
    return $this->belongsTo(AlertRequest::class, 'request_id');
  }

  public function response()
  {
      return $this->belongsTo(User::class, 'response_id');
  }

}
