<?php

namespace App\Http\Controllers;

use App\ResponseFormatter;
use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function getSliders()
    {
        $sliders = \App\Models\Slider::all();
        return ResponseFormatter::success($sliders->pluck('api_response'));
    }

    public function getCategories()
    {
        $categories = Category::whereNull('parent_id')->with('childs')->get();
        return ResponseFormatter::success($categories->pluck('api_response'));
    }
}
