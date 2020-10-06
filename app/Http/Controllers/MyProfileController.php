<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use App\Mail\VerifyMail;
use App\News;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class MyProfileController extends Controller
{
    public function index()
    {
        $news = News::where('user_id', auth()->user()->id)->with('user')->with('category')->orderBy('created_at', 'DESC')->paginate(5);

        $my_comments_count = Comment::where('user_id', auth()->user()->id)->whereHas('news', function ($query) {
            $query->where('block', 1)->whereHas('user', function ($query){
                $query->where('id', '!=', auth()->user()->id);
            });
        })->count();

        $my_news_comments_count = Comment::join('news', 'comments.news_id', 'news.id')->where('news.user_id', '=', auth()->user()->id)->where('comments.user_id', '!=', auth()->user()->id)->whereHas('news', function ($query) {
            $query->where('block',1);
        })->count();

        $my_likes_count = Like::where('user_id', auth()->user()->id)->whereHas('news', function ($query) {
            $query->where('block', 1);
        })->count();

        $my_news_likes_count = Like::join('news', 'likes.news_id', 'news.id')->where('news.user_id', '=', auth()->user()->id)->where('likes.user_id', '!=', auth()->user()->id)->whereHas('news', function ($query) {
            $query->where('block', 1);
        })->count();

        return view('admin.pages.profile.index')
            ->with('news', $news)
            ->with('my_comments_count', $my_comments_count)
            ->with('my_news_comments_count', $my_news_comments_count)
            ->with('my_likes_count', $my_likes_count)
            ->with('my_news_likes_count', $my_news_likes_count);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'min:3|max:50|nullable',
           'avatar' => 'image|mimes:jpeg,png,jpg|max:204|nullable',
            'password' => [
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
                'nullable'
            ],
           'phone' => 'size:10|nullable',
           'job' => 'min:5|nullable',
           'address' => 'min:5|max:150|nullable',
           'facebook' => 'min:5|max:255|nullable',
           'twitter' => 'min:5|max:255|nullable',
           'youtube' => 'min:5|max:255|nullable'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            if ($request->name != auth()->user()->name && $request->name != null) auth()->user()->name = $request->name;

            if ($request->password != null) auth()->user()->password = bcrypt($request->password);
            if ($files = $request->file('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . $avatar->getClientOriginalExtension();
                $path = asset('images/users/avatar/' . $filename . '.jpg');
                Image::make($avatar->getRealPath())->save(public_path('images/users/avatar/' . $filename . '.jpg'));

                auth()->user()->avatar = $path;
            }

            if ($request->job != null && $request->job != auth()->user()->job) auth()->user()->job = $request->job;

            if ($request->phone != auth()->user()->phone && $request->phone != null) auth()->user()->phone = $request->phone;
            if ($request->address != auth()->user()->address && $request->address != null) auth()->user()->address = $request->address;
            if ($request->facebook != auth()->user()->facebook && $request->facebook != null) auth()->user()->facebook = $request->facebook;
            if ($request->twitter != auth()->user()->twitter && $request->twitter != null) auth()->user()->twitter = $request->twitter;
            if ($request->youtube != auth()->user()->youtube && $request->youtube != null) auth()->user()->youtube = $request->youtube;

            auth()->user()->update();

            return redirect()->back()->with('message', 'Profiliniz güncellendi')->with('status', 'success');
        }

    }
}
