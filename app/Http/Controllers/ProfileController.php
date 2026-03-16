<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFormatter;
use Illuminate\Support\Facades\Validator;

use function Symfony\Component\Translation\t;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = request()->user();
        return ResponseFormatter::success($user->api_response);
    }

    public function updateProfile()
    {
        $validator = Validator::make(request()->all(), [
            
            'name' => 'required|max:100',
            'email' => 'required| email',
            'phone' => 'nullable|numeric',
            'username' => 'nullable|min:2|max:20',
            'photo_url' => 'nullable|image|max:2048',
            'store_name' => 'nullable|max:100|min:5',
            'gender' => 'required|in:male,female,other',
            'birth_date' => 'nullable|date_format:Y-m-d',
        ]);
        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $payload = $validator->validated();
        if (!is_null(request()->photo)) {
            $payload['photo'] = request()->file('photo')->store(
                'user-photo', 'public');
        }
        request()->user()->update($payload);
        return $this->getProfile();
    }
}
