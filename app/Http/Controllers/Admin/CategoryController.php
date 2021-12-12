<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create', [
            'category' => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => '',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => ['required'],
            'description' => 'nullable',
            'image' => 'nullable', 'image',
        ];
        $messages = [
            'title.required' => 'Это поле обязательно для заполнения',
            'image.image' => 'Только изображения'
        ];
        $data = Validator::make($request->all(), $rules, $messages)->validate();
        $data['image'] = uploadImage($request);
        Category::create($data);

        return redirect()->route('category.index')->with('success', 'Категория добавлена');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', [
            'category' => $category,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $rules = [
            'title' => ['required'],
            'description' => '',
            'image' => ''
        ];
        $messages = [
            'title.required' => 'Это поле обязательно для заполнения',
        ];

        $data = Validator::make($request->all(), $rules, $messages)->validate();

        $data['image'] = uploadImage($request, $category->image);

        $category->update($data);

        return redirect()->back()->with('success', 'Категория обновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $cat = Category::find($category->id);
        if($cat->posts->count()){
            return redirect()->route('category.index')->with('error', 'Ошибка! У категории есть записи. Удалите сначала их, или перенесите в другую категорию');
        }
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Категория удалена');
    }
}
