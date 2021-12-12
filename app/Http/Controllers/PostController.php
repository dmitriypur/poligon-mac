<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reklama;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::orderBy('id', 'DESC')->with('likes')->paginate(5);
        $title = 'Новости';

        if($request->ajax()){
            $view = view('parts.data', compact('posts'))->render();
            return response()->json(['html' => $view]);
        }
        return view('frontend.post.index', compact('posts', 'title'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->view_count += 1;
        $post->update();
        return view('frontend.post.show', compact('post'));
    }
}
