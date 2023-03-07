<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Auth\OtpSent;
use App\Models\Auth\Otp;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    use HttpResponses;
    public function sendOtp(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                'type' => 'bail|required|in:register,reset',
                'email' => 'required|email|max:100',
            ],
        );

        // dd($validator);
        $validator->sometimes('type', 'bail|exists:customers,email', function ($input) {
            return $input->type == 'reset';
        })->validate();
        $validator->sometimes('type', 'bail|unique:customers,email', function ($input) {
            return $input->type == 'register';
        })->validate();

        $validated = $validator->safe()->only(['type', 'email']);

        $sixDigit = mt_rand(100000, 999999);
        // if previous otp exists
        $otp = Otp::updateOrCreate(
            ['email' => $validated['email']],
            ['code' => $sixDigit]
        );
        Mail::to($otp->email)->send(new OtpSent($otp, $validated['type']));
        
        return $this->success(null, "OTP Sent Successfully");

    }

    public function verifyOtp(Request $req)
    {
        $validator = $req->validate([
            'email' => 'required|email|exists:otps,email',
            'otp' => 'required|size:6'
        ]);

        $otpVerified = Otp::where(['email' => $validator['email'], 'code' => $validator['otp']])->first();
        if($otpVerified){
            $otpVerified->update(['otp_verified' => true, 'email_verified_at' => now()]);
            return $this->success(null, "OTP Verified Successfully !");
        }
        else{
            return $this->error(null, "Invalid OTP !", 401);
        }

    }


}
