<?php

namespace App\Http\Controllers;

use App\Comment;
use App\News;
use App\NewsByCategory;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $news = News::where('user_id', "!=", auth()->user()->id)->get();


        return view('admin.pages.news.index')->with('news', $news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $slug
     * @return Response
     */
    public function update($slug)
    {
        $new = News::where('slug', $slug)->firstOrFail();

        $new->block = !$new->block;
        $new->update();

        return redirect()->route('news')->with('message', 'Haber güncellendi')->with('status', 'info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return Response
     */
    public function destroy(Request $request)
    {
        News::where('id', $request->id)->delete();

        return redirect()->route('news')->with('message', 'Haber başarılı bir şekilde silindi')->with('status', 'info');
    }

    public function deleteAllNews()
    {
        News::where('user_id', '!=', auth()->user()->id)->delete();
        return redirect()->route('news')->with('message', 'Tüm haberler başarılı bir şekilde silindi')->with('status', 'info');
    }
}
