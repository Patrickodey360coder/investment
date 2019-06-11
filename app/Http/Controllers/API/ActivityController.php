<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
    	return response()->json([
            'activities' => $request->user()->activities,
        ], 200);
    }
}
