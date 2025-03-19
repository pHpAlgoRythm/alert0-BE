<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Models\PendingAccounts;

class RegisterController extends BaseController
{

    public function PendingAccounts(Request $request)
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
            'phone' => 'required',
            'verification_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $pendingUser = PendingAccounts::create($input);


        return $this->sendResponse(['name' => $pendingUser->name], 'Waiting for Approval');

    }

     /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function Register($id)
    {

        $pendingUser = PendingAccounts::findorFail($id);

        $user = User::create([
            'name' => $pendingUser->name,
            'email' => $pendingUser->email,
            'password' => $pendingUser->password,
            'address' => $pendingUser->address,
            'role' => $pendingUser->role,
            'status' => 'approved',
            'phone' => $pendingUser->phone
        ]);

        $pendingUser->delete();

        $token = $user->createToken('myApp')->plainTextToken;

      return $this->sendResponse(['token' => $token, 'name' => $user->name], 'User Registered Successfully.');
    }

    public function updatePersonalInfo(Request $request, string $id)
    {

        $user = User::find($id);

        if (!$user) {
            return $this->sendError('user not found.', [], 404);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes',
            'c_password' => 'sometimes|same:password',
            'address' => 'sometimes',
            'gender' => 'sometimes',
            'role' => 'sometimes',
            'status' => 'sometimes',
            'phone' => 'sometimes',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $user->update($request->all());

        return $this->sendResponse($user, 'User updated Successfully.');
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
                $success['id'] = $user->id;
                $success['message'] = $user->name;
                $success['role'] = $user->role;


                return $this->sendResponse( $success, 'User Login Successfully');
        }else{
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }
     }



     public function retrieveDriver(Request $request): JsonResponse
     {
        $driver = User::where('role', 'driver')->get();

        return $this->sendResponse($driver, 'Drivers');
     }

     public function retrieveResponder(Request $request): JsonResponse
     {
        $responder = User::Where('role', 'responder')->get();

        return $this->sendResponse($responder, 'responder');
     }
}


