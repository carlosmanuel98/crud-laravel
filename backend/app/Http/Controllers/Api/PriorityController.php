<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Priority;

class PriorityController extends Controller
{
    public function index()
    {
        $priorities = Priority::orderBy('id')->get();

        return response()->json([
            'success' => true,
            'data' => $priorities,
        ]);
    }
}
