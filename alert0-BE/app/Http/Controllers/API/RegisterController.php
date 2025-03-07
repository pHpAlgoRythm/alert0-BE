<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class RegisterController extends BaseController
{
     /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'address' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'status' => 'required',
            'phone' => 'required|min:11|max:11'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('myApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User Registered Successfully.');

    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

     public function login(Request $request): JsonResponse
     {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password ])){
                $user = Auth::user();
                $success['token'] = $user->createToken('myApp')->plainTextToken;
                $success['message'] = $user->name;

                return $this->sendResponse( $success, 'User Login Successfully');
        }else{
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }
     }
}


