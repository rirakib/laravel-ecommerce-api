<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ResponseController as Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;



class RegistrationController extends Controller
{
    public function login(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);



            if($validateUser->fails()){
                return $this->sendError('validation error',$validateUser->errors(),401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return $this->sendError('Email Or Password does not match with our record.',401);
            }
            $user = User::where('email', $request->email)->first();

            return $this->sendResponse($user->createToken("API TOKEN")->plainTextToken,'Logged In Successfull');



        } catch (\Throwable $th) {

            return $this->sendError('failed',$th->getMessage(),500);

        }
    }
}
