<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFormatter;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthenticationController extends Controller
{
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->fails());
        }

        do{
            $otp = rand(1000000, 999999);
            $otpCount = user::where('otp_register', $otp)->count();
        } while ($otpCount > 0);

        $user = User::create([
            'email' => request()->email,
            'name' => request()->name,
            'otp_register' => $otp
        ]);

        return ResponseFormatter::success([
            'is_sent' => true
        ]);
    }
    public function verifyOtp()
    {

    }
    public function verifyRegister()
    {

    }
}
