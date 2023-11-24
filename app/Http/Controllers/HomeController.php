<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        return view('page.homepage.index');
    }

    public function showPost(Request $request, string $by, string|int $param): View
    {
        $post = Post::where($by, '=', $param)->first();
        $post->increment('view_count');
        return view('page.post.show', compact('post'));
    }

    public function tag(Request $request, string $tag): View
    {
        $posts = Tag::where('name', '=', $tag)->first()->posts;
        return view('tag.post', compact('post'));
    }
}
