<?php

namespace App\Http\Controllers\auth;


use App\Mail\UserCreated;
use App\Models\Customer\Customer;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HttpResponses;
    use HasApiTokens, HasFactory, Notifiable;

    public function login(Request $request): JsonResponse
    {
         $validator = Validator::make(
            $request->all(),
            [
                'method' => 'bail|required|in:email,contact',
                'password' => 'bail|required'
            ],
            // do not change the validation message, view will ask customer to register based on this
            ['identifier.exists' => 'User not found!']
        );

        $validator->sometimes('identifier', 'bail|required|email|max:100|exists:customers,email', function ($input) {
            return $input->method == 'email';
        })->validate();
        $validator->sometimes('identifier', 'bail|required|numeric|min_digits:10|max_digits:15|exists:customers,contact', function ($input) {
            return $input->method == 'contact';
        })->validate();

        $validated = $validator->safe()->only(['method', 'identifier', 'password']);
        $credentials = [$validated['method'] => $validated['identifier'], 'password' => $validated['password']];

        if(Auth::guard('customer')->attempt($credentials)){
            $request->session()->regenerate();
            // $user = Customer::where("email", $credentials['email'])->first();
            return $this->success([
                'Logged In Successfully !'
            ]);
        }
        else{
            return $this->error(null,"Credentials do not match", 401);  
        }
        
    }

    public function register(Request $req):JsonResponse
    {
        $validator = $req->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email|max:100',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'contact' => 'nullable|numeric|min:10|max:15|unique:customers,contact'
        ]);
        // dd($validator);
        // $validator = $validator->safe()->only(['name', 'email', 'password', 'c_password', 'contact']);

        if($validator){
            $validator['password'] = Hash::make($validator['password']);
            $user = Customer::create($validator);

            Auth::guard('customer')->login($user);
            $req->session()->regenerate();
            // $user->createToken("Api Token of ".$user->name)->plainTextToken;
            // event(new UserCreated($user));

            return $this->success([
                'user' =>$user,
            ]);
        }
        else{
            return $this->error($req->email, "Validation Error", 500);
        }


    }

    public function logout(Request $req){

        // Auth::user()->currentAccessToken()->delete();
        Auth::guard('customer')->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        
        return $this->success("","Logged Out Successfully");
    }

    public function details(Request $req):JsonResponse
    {
        $user = Auth::guard('customer')->user();
        return $this->success([
            'user' => $user
        ]);
    }
}
