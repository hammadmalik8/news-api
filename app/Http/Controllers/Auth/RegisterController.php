<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Http\Response;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation.
    |
    */

    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $user = User::where('email', $req->email)->first();

        if ($user) {
            return response()->json([
                'status' => 403,
                'message' => 'Email is being used by another account.',
            ]);
        }

        $User = new User;
        $User->name = $req['name'];
        $User->email = $req['email'];
        $User->password = Hash::make($req['password']);
        $User->save();

        return response()->json([
            'status' => 201,
            'message' => "Your account has been created successfully",
        ]);
    }
}
