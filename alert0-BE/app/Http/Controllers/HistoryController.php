<?php

namespace App\Http\Controllers;

use App\Models\history;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController as BaseController;

class HistoryController extends BaseController
{
   public function showAllHistory(): JsonResponse
   {
    $histories = history::all();
    return $this->sendResponse($histories, 'displaying all histories');
   }

   public function createHistory(Request $request): JsonResponse
   {
    $validator = Validator::make($request->all(), [
        'request_id' => 'sometimes|exists:alert_requests,id',
        'response_id' => 'sometimes|exists:response,id',
        'vehicle_number' => 'sometimes'
    ]);

    if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors());
    }

    $history = history::create([
        'request_id' => $request['request_id'],
        'response_id' => $request['response_id'],
        'vehicle_number' => $request['vehicle_number'],
    ]);

    return $this->sendResponse($history, 'created');
   }
}
