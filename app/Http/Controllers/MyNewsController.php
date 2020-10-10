<?php

namespace App\Http\Controllers;

use App\News;
use App\NewsByCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class MyNewsController extends Controller
{
    public function create()
    {
        return view('admin.pages.mynews.add')->with('categories', NewsByCategory::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:204',
            'state' => 'required',
            'category' => 'required',
            'summary' => 'required|min:20',
            'content_news' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if ($files = $request->file('image')) {
            $image = $request->file('image');
            $filename = time().$image->getClientOriginalExtension();
            $path = asset('images/news/'.$filename.'.jpg');
            $resize_path = asset('images/news/resize/'.$filename.'.jpg');
            Image::make($image->getRealPath())->save(public_path('images/news/'.$filename.'.jpg'));
            Image::make($image->getRealPath())->resize(540, 401)->save(public_path('images/news/resize/'.$filename.'.jpg'));

            $news = new News();
            $news->title = $request->title;
            $news->state = $request->state == 'active' ? true : false;
            $news->user_id = auth()->user()->id;
            $news->image = $path;
            $news->resize_image = $resize_path;
            $news->summary = $request->summary;
            $news->content = $request->content_news;
            $news->category_id = $request->category;
            $news->block = 1;
            $news->save();

            return redirect()->route('myprofile')->with('message', 'Haber eklendi')->with('status', 'success');
        } else {
            return redirect()->back()->with('message', 'Haber resmi bulunamadı')->with('status', 'warning');
        }
    }

    public function show($slug)
    {
        $news = News::whereSlug($slug)->firstOrFail();

        if ($news->block === 0) {
            dd($news->block);
            return redirect()->back();
        }

        $categories = NewsByCategory::all();

        return view('admin.pages.mynews.edit')->with('news', $news)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $slug
     * @return Response
     */
    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:255',
            'image' => 'image|mimes:jpeg,png,jpg|max:204',
            'state' => 'required',
            'category' => 'required',
            'summary' => 'required|min:20',
            'content_news' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }


        $news = News::whereSlug($slug)->firstOrFail();

        if ($news->block === 0) {
            return redirect()->back();
        }

        $news->slug = null;

        if ($files = $request->file('image')) {
            $image = $request->file('image');
            $filename = time() . $image->getClientOriginalExtension();
            $path = asset('images/news/' . $filename . '.jpg');
            $resize_path = asset('images/news/resize/'.$filename . '.jpg');
            Image::make($image->getRealPath())->save(public_path('images/news/' . $filename . '.jpg'));
            Image::make($image->getRealPath())->resize(540, 401)->save(public_path('images/news/resize/' . $filename . '.jpg'));

            $news->image = $path;
            $news->resize_image = $resize_path;
        }

        if ($news->title != $request->title && $request->title != "") {
            $news->title = $request->title;
        }

        if ($request->state != null) {
            $news->state = $request->state == 'active' ? true : false ;
        }

        if ($request->summary != $news->summary) $news->summary = $request->summary;
        if ($request->content_news != $news->content) $news->content = $request->content_news;
        if ($request->category != $news->category_id) $news->category_id = $request->category;

        $news->update();

        return redirect()->route('myprofile')->with('message', 'Haber güncellendi')->with('status', 'info');
    }

    public function destroy(Request $request)
    {
        News::where('id', $request->id)->delete();

        return redirect()->route('myprofile')->with('message', 'Haber başarılı bir şekilde silindi')->with('status', 'info');
    }

    public function deleteAllMyNews()
    {
        News::where('user_id', auth()->user()->id)->delete();

        return redirect()->route('myprofile')->with('message', 'Tüm içerikleriniz silindi')->with('status', 'info');
    }
}
