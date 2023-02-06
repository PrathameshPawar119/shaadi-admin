<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Jobs\UserCreatedJob;
use App\Mail\UserCreated as MailUserCreated;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class AuthController extends Controller implements ShouldQueue, ShouldBeUnique
{
    use HttpResponses;
    use HasApiTokens, HasFactory, Notifiable;

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
        $user->createToken("Api Token of ".$user->name)->plainTextToken;

        event(new UserCreated($user));
        // Mail::to($user->email)->send(new MailUserCreated($user));
        // $data = Arr::except($user, ['id', 'updated_at', 'created_at']);
        // $data = array("name" => $user->name, "email" => $user->email);
        // dispatch(new UserCreatedJob($data));

        return $this->success([
            'user' =>$user,
        ]);

    }

    public function logout(Request $req){

        Auth::user()->currentAccessToken()->delete();
        
        return $this->success("","Logged Out Successfully");
    }
}
