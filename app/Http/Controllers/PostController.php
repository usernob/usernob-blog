<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function show(Request $request, string $by, string|int $param): View
    {
        $post = Post::where($by, '=', $param)->first();
        return view('page.post.show', compact('post'));
    }
}
