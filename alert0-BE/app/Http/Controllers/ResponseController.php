<?php

namespace App\Http\Controllers;

use App\Models\response;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\AlertRequest;
use App\Models\User;



class ResponseController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $response = response::all();
        return $this->sendReponse($response, 'this is all responses');
    }

    
    public function storeResponse(Request $request): JsonResponse
{
    $validator = Validator::make($request->all(), [
        'request_id' => 'sometimes|exists:alert_requests,id',
        'responders_id' => 'sometimes|exists:users,id',
        'drivers_id' => 'sometimes|exists:users,id',
        'current_latitude' => 'sometimes|numeric',
        'current_longitude' => 'sometimes|numeric'
    ]);

    if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors());
    }

    $response = response::create([
        'request_id' => $request['request_id'],
        'responders_id' => $request['responders_id'],
        'drivers_id' => $request['drivers_id'],
        'current_latitude' => $request['current_latitude'],
        'current_longitude' => $request['current_longitude']
    ]);

    return $this->sendResponse($response, 'New Response');
}

public function displayAssignment(Request $request): JsonResponse
{
   

    $response = response::with(['alertRequest', 'responder', 'driver'])->where('request_status','new')->get();
                        

    if (!$response) {
            return $this->sendError('Response not found.');
        }

    return $this->sendResponse($response, 'Assignment Details');

}

public function updateStatus(Request $request, string $id): JsonResponse
{
    $response = response::find($id);

    if ($response->responders_response === 'responded' && $response->drivers_response === 'responded') {
        $response->update(['request_status' => 'in_progress']);
        $response->refresh();
        return $this->sendResponse($response, 'Request status updated to in_progress');
    }

    return $this->sendResponse($response, 'Conditions not met to update status');
}


    public function updateResponderResponse(Request $request, string $id): JsonResponse
    {
        $response = response::find($id);

        $response->update(['responders_response' => 'responded']);

        $response->refresh();

        if ($response->drivers_response === 'responded') {
            $response->update(['request_status' => 'in_progress']);
        }

        return $this->sendResponse($response, 'updated successfully');

    }

    public function updateDriverResponse(Request $request, string $id): JsonResponse
    {
        $response = response::find($id);

        $response->update(['drivers_response' => 'responded']);
        $response->refresh();

        if ($response->responders_response === 'responded') {
            $response->update(['request_status' => 'in_progress']);
        }

        return $this->sendResponse($response, 'updated successfully');

    }

    public function updateResponseLocation(Request $request, string $id): JsonResponse
    {
        $response = response::find($id);
    
        if (!$response) {
            return $this->sendError('Response not found.');
        }
    
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);
    
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
    
        $response->current_latitude = $request->latitude;
        $response->current_longitude = $request->longitude;
        $response->save();
    
        return $this->sendResponse($response, 'Location updated successfully.');
    }
    


}