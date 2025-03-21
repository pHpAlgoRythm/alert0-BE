<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Events\pendingUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
            'approval_status' => 'required',
            'approval_id_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'approval_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'status' => 'required',
            'phone' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        try{
            DB::beginTransaction();

            $approvalIdPath = $request->file('approval_id_photo')->store('pending_approval', 'public');
            $approvalPhotoPath = $request->file('approval_photo')->store('pending_approval', 'public');

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'approval_status' => $request->approval_status,
                'approval_id_photo' => asset('storage/' . $approvalIdPath),
                'approval_photo' => asset('storage/' . $approvalPhotoPath),
                'address' => $request->address,
                'gender' =>  $request->gender,
                'role' =>  $request->role,
                'status' =>  $request->status,
                'phone' =>  $request->phone,
            ]);


            $success['data']  = $user;

            DB::commit();


            return $this->sendResponse($success, 'User Registered Successfully wait for approval.');

        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'something went wrong. Please try again.',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
             ], 500);
        }

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

     //get users

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


     public function getPendingUsers(Request $request): JsonResponse
     {
        $pendingUsers = User::Where('approval_status', 'pending')->get();

        return $this->sendResponse($pendingUsers, 'pending users');
     }

}
