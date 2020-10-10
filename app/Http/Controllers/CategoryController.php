<?php

namespace App\Http\Controllers;

use App\News;
use App\NewsByCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = NewsByCategory::all();
        return view('admin.pages.category.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required|min:3|max:255|unique:news_by_categories',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $category = new NewsByCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        $category->save();

        return redirect()->back()->with('message', 'Kayıt işlemi tamamlandı')->with('status', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NewsByCategory  $newsByCategory
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $category = NewsByCategory::whereSlug($slug)->firstOrFail();

        return view('admin.pages.category.edit')->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NewsByCategory  $newsByCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsByCategory $newsByCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewsByCategory  $newsByCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
           'name' =>'required|min:3|max:255|unique:news_by_categories'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $category = NewsByCategory::whereSlug($slug)->firstOrFail();
        $category->slug = null;

        if ($request->name === $category->name) {
            return redirect()->route('category')->with('message', 'Herhangi bir değişiklik bulunamadı')->with('status', 'warning');
        }

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->update();

        return redirect()->route('category')->with('message', 'İşlem başarılı bir şekilde tamamlandı')->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewsByCategory  $newsByCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        NewsByCategory::where('id', $request->id)->delete();

        return redirect()->route('category')->with('message', 'Kategori başarılı bir şekilde silindi')->with('status', 'info');
    }

    public function deleteAllCategory()
    {
        NewsByCategory::whereNotNull('id')->delete();
        return redirect()->route('category')->with('message', 'Tüm kategoriler başarılı bir şekilde silindi')->with('status', 'info');
    }
}
