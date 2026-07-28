<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id')->get();

        return response()->json([
            'success' => true,
            'data' => $tags,
        ]);
    }
}
