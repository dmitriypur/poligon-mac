<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::with('posts')->get();
        $title = 'Все категории';
        return view('frontend.category.index', compact('categories', 'title'));
    }

    public function show(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->orderBy('id', 'DESC')->with('likes')->paginate(3);
        $title = "Новости категории '{$category->title}'";
        $reklama = $category->reklamas()->get();

        if($request->ajax()){
            $view = view('parts.data', compact('posts', 'reklama'))->render();
            return response()->json(['html' => $view]);
        }
        return view('frontend.category.posts', compact('posts', 'title', 'category', 'reklama'));
    }
}
