<?php

namespace App\Http\Controllers;

use App\Models\patient_care_reports;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController as BaseController;


class PatientCareReportsController extends BaseController
{
    
   public function retrieveReport(): JsonResponse 
   {
    $patientCareReport = patient_care_report::all();

    return $this->sendResponse($patientCareReport, 'patients care report');
   }

   public function storeReport(Request $request): JsonResponse
   {

    $validator = Validator::make($request->all(), [
        'request_id' => 'required|exists:alert_requests,id',
        'history_id' => 'required|exists:history,id',
        'triage' => 'required|in:red,yellow,green,black',
        'trauma' => 'required|boolean',
        'medical' => 'required|boolean',
        'patient_information' => 'required',
        'address' => 'required',
        'care_onprogress_upon_arrival' => 'required|in:bystander,family,brgy personnel,pnp/cttramo,medical proffesional,ems,others',
        'signs&syntoms' => 'required'
    ]);

   } 

}
