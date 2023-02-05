<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $req){

        $req->validated($req->all());

        if(! Auth::attempt($req->only('email', 'password'))){
            return $this->error($req->email, "Credentials do not match", 400);  
        }
        $user = User::where("email", $req->email)->first();
        
        return $this->success([
            'user' => $user,
            'token' => $user->createToken("API Token of ".$user->name)->plainTextToken
        ]);
    }

    public function register(StoreUserRequest $req){

        $req->validated($req->all());
        $user = User::create([
            'name' => $req->name,
            'email' =>$req->email,
            'password' => Hash::make($req->password)
        ]);

        return $this->success([
            'user' =>$user,
            'token' => $user->createToken("API Token of ".$user->name)->plainTextToken
        ]);
    }

    public function logout(Request $req){

        Auth::user()->currentAccessToken()->delete();
        
        return $this->success("","Logged Out Successfully");
    }
}
