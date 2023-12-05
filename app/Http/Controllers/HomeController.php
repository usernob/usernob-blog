<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('page.homepage.index');
    }

    public function showPost(Request $request, string $by, string|int $param): View
    {
        $post = Post::where($by, '=', $param)->first();
        $post->increment('thismonth_view_count');
        return view('page.post.show', compact('post'));
    }

    public function getPostByTag(string $tag): View
    {
        $posts = Tag::where('name', '=', $tag)->first()->posts;
        return view('page.tag.post', ['posts' => $posts, "tagname" => $tag]);
    }

    public function search(): View
    {
        return view('page.search.index');
    }

    public function tag(): View
    {
        $tags = Tag::orderBy("name")->get();
        return view('page.tag.index', compact('tags'));
    }

    public function about() : View
    {
        return view('page.about.index');
    }
}
