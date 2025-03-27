<?php

// Base Controller ni siya where in ga handle sang pag send sang response sa api as Json

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
Use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

     //ma send ni if success ang transaction
     public function sendResponse($result, $message)
     {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
     }

         /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */

    //  ma send ni if mai error sa transaction
     public function sendError($error, $errorMessages = [], $code = null)
     {

        if ($code === null) {
            $code = is_array($errorMessages) && !empty($errorMessages) ? 422 : 400;
        }

        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);

     }

}
