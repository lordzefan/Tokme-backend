<?php

namespace App\Http\Controllers;

use App\ResponseFormatter;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getSliders()
    {
        $sliders = \App\Models\Slider::all();
        return ResponseFormatter::success($sliders->pluck('api_response'));
    }
}
