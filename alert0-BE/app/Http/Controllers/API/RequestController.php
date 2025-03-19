<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\AlertRequest;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\alertRequestResource;
use Illuminate\Support\Facades\Storage;

class RequestController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $requests = AlertRequest::all();
        return $this->sendResponse($requests, 'Requests retrieved successfully.');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|exists:users,id',
            'request_type'  => 'required|string',
            'request_status'=> 'required|in:pending,in_progress,completed,rejected',
            'request_date'  => 'required|date',
            'longitude'     => 'required|numeric',
            'latitude'      => 'required|numeric',
            'request_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }




        $path = $request->file('request_photo')->store('request_photo', 'public');

        $alertRequest = AlertRequest::create([
            'user_id'       => $request->user_id,
            'request_type'  => $request->request_type,
            'request_status'=> $request->request_status,
            'request_date'  => $request->request_date,
            'longitude'     => $request->longitude,
            'latitude'      => $request->latitude,
            'request_photo' => $path,
        ]);

        return $this->sendResponse(new alertRequestResource($alertRequest), 'Request is sent successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $alertRequest = AlertRequest::find($id);

        if (!$alertRequest) {
            return $this->sendError('Request not found.', [], 404);
        }

        return $this->sendResponse( new alertRequestResource($alertRequest), 'Request retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $alertRequest = AlertRequest::find($id);

        if (!$alertRequest) {
            return $this->sendError('Request not found.', [], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id'       => 'sometimes|exists:users,id',
            'request_type'  => 'sometimes|string',
            'request_status'=> 'sometimes|in:pending,in_progress,completed,rejected',
            'request_date'  => 'sometimes|date',
            'longitude'     => 'sometimes|numeric',
            'latitude'      => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $alertRequest->update($request->all());

        return $this->sendResponse(new alertRequestResource($alertRequest), 'Request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $alertRequest = AlertRequest::find($id);

        if (!$alertRequest) {
            return $this->sendError('Request not found.', [], 404);
        }

        $alertRequest->delete();
        return $this->sendResponse([], 'Request deleted successfully.');
    }
}
