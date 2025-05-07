<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class patient_care_reports extends Model
{
    protected $table = 'patient_care_reports';

    protected $fillable = [
        'request_id',
        'history_id',
        'triage',
        'trauma',
        'medical',
        'patient_information',
        'address',
        'care_onprogress_upon_arrival',
        'signs&syntoms',
        'allergies',
        'medications',
        'past_med',
        'last_oral_intake',
        'event_prior_to_illness',
        'chief_complaint',
        'coma_scale_eye',
        'coma_scale_verbal',
        'coma_scale_motor',
        'vital_signs',
        'pulse',
        'skin_color',
        'skin_temp	',
        'skin_moisture',
    ];


    public function alertRequest()
  {
    return $this->belongsTo(AlertRequest::class, 'request_id');
  }

  
}
