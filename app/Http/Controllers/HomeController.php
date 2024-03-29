<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use App\Mail\Bulletin;
use App\Mail\MessageBulletin;
use App\News;
use App\NewsByCategory;
use App\Slider;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {

        SEOMeta::setTitle(env('APP_NAME'));
        SEOMeta::setDescription('Yazılım blog paylaşma platformu');
        SEOMeta::setCanonical('https://emirgokkaya.com');
        SEOMeta::addKeyword(['blog', 'paylaşım', env('APP_NAME'), 'post']);

        OpenGraph::setTitle('emirgokkaya');
        OpenGraph::setDescription('Yazılım blog paylaşma platformu');
        OpenGraph::setUrl('https://emirgokkaya.com');
        OpenGraph::addProperty('type', 'blogs');

        TwitterCard::setTitle('emirgokkaya_');
        TwitterCard::setSite('@emirgokkaya_');

        $sliders = Slider::where('state', 1)->with('user')->limit(3)->get();

        /*if (News::where('state', 1)->with('user')->with('category')->orderBy('created_at', 'DESC')->first() != null) {
            $lastNew = News::where('state', 1)->with('user')->with('category')->orderBy('created_at', 'DESC')->first();
        }
        else {
            return view('index')->with('sliders', $sliders);
        }*/

        $most_comments_news = News::where('state', 1)->where('block', 1)->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->limit(4)->get();

        $last_news = News::where('state', 1)->where('block', 1)->orderBy('created_at', 'DESC')->limit(4)->get();


        $like_popular_array = Like::select('news_id')->groupBy('news_id')->orderByRaw('COUNT(*) DESC')->limit(4)->pluck('news_id');

        /*$most_like_post = News::whereIn('id', $like_popular_array)->with(['likes' => function($query) {
            $query->where('user_id', auth()->user()->id);
        }])->get();*/

        $most_like_post = News::where('block', 1)->where('state', 1)->whereIn('id', $like_popular_array)->with('likes')->get();


        $news = News::where('state', 1)->where('block', 1)->with('user')->with('category')->orderBy('created_at', 'DESC')->limit(4)->get();


        $categories = NewsByCategory::all();


        return view('index')
            ->with('sliders', $sliders)
            ->with('news', $news)
            ->with('categories', $categories)
            ->with('most_comments_news', $most_comments_news)
            ->with('last_news', $last_news)
            ->with('most_like_post', $most_like_post);
    }

    public function about()
    {
	    return redirect()->back();
        // return view('about');
    }

    public function blogs()
    {
        $blogs = News::with('category')->with('user')->where('state', 1)->where('block', 1)->orderBy('created_at', 'DESC')->paginate(7);

        SEOMeta::setTitle('Bloglar');
        SEOMeta::setDescription('Tüm Bloglar');
        SEOMeta::addKeyword(['blog', 'içerik', 'yazılım', 'post', 'bloglar', 'developer', 'content']);

        OpenGraph::setDescription('Tüm Bloglar');
        OpenGraph::setTitle('Bloglar');
        OpenGraph::setUrl(route('blogs'));
        OpenGraph::addProperty('type', 'blogs');

        TwitterCard::setTitle('emirgokkaya_');
        TwitterCard::setSite('@emirgokkaya_');

        return view('blogs')->with('blogs', $blogs);
    }

    public function blog_detail($slug)
    {
        $blog = News::whereSlug($slug)->where('state', 1)->where('block', 1)->with('user')->with('category')->firstOrFail();

        SEOMeta::setTitle($blog->title);
        SEOMeta::setDescription($blog->summary);
        SEOMeta::addMeta('blog:published_time', $blog->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('blog:section', $blog->category->name, 'property');
        SEOMeta::addKeyword([$blog->category->name, 'kategoriler', 'bloglar', 'postlar', 'blogs', 'post', 'categories', 'category']);

        OpenGraph::setDescription($blog->summary);
        OpenGraph::setTitle($blog->title);
        OpenGraph::setUrl(route('blog_detail', ['slug' => $blog->slug]));
        OpenGraph::addProperty('type', 'blog');
        OpenGraph::addProperty('locale', 'tr-TR');
        OpenGraph::addProperty('locale:alternate', ['en-us']);
        OpenGraph::addImage($blog->image);

        TwitterCard::setTitle('emirgokkaya_');
        TwitterCard::setSite('@emirgokkaya_');

        $comments = Comment::where('news_id', $blog->id)->where('state', 1)->with('user')->orderBy('created_at', 'DESC')->get();
        $likes = Like::where('news_id', $blog->id)->count();
        if(auth()->user()) {
              $css = Like::where('user_id', auth()->user()->id)->where('news_id', $blog->id)->count();
        } else {
           $css = 0;
        }
        return view('blog_detail')->with('blog', $blog)->with('comments', $comments)->with('likes', $likes)->with('css', $css);
    }

    public function comment_post(Request $request, $news)
    {
        $validator = Validator::make($request->all(), [
           'comment' => 'required|min:3|max:500'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (auth()->user()->role === "admin" || auth()->user()->role === "editor") {
            $comment = new Comment();
            $comment->news_id = $news;
            $comment->user_id = auth()->user()->id;
            $comment->state = 1;
            $comment->comment = $request->comment;

            $comment->save();

            return redirect()->back()->with('message', 'Yorum kaydedildi')->with('status', 'success');
        }
        else {
            return redirect()->back()->with('message', 'Yorum kaydetme başarısız oldu')->with('status', 'danger');
        }
    }

    public function add_like($id)
    {
        $like = Like::where('user_id', auth()->user()->id)->where('news_id', $id)->count();
        if ($like === 1)
        {
            Like::where('user_id', auth()->user()->id)->where('news_id', $id)->delete();
        }
        else
        {
            $addlike = new Like();
            $addlike->user_id = auth()->user()->id;
            $addlike->news_id = $id;

            $addlike->save();
        }

        return redirect()->back();
    }

    public function delete_comment($news_slug, $id)
    {
        /*$comment = Comment::whereHas('news', function($query) use ($news_slug) {
            $query->whereSlug($news_slug)->get();
        })->where('id', $id)->get();*/
        Comment::whereHas('news', function ($query) use ($news_slug) {
           $query->where('slug', $news_slug);
        })->whereId($id)->delete();
        return redirect()->back()->with('message', 'Yorum silindi')->with('status', 'info');
    }

    public function categories()
    {
        SEOMeta::setTitle('Kategoriler');
        SEOMeta::setDescription('Kategorilerine göre blog listesi');
        SEOMeta::addKeyword(['blog', 'kategori', 'kategoriler', 'categories', 'category', 'yazılım', 'post', 'bloglar', 'developer', 'content']);

        OpenGraph::setDescription('Tüm Kategoriler');
        OpenGraph::setTitle('Kategoriler');
        OpenGraph::setUrl(route('categories'));
        OpenGraph::addProperty('type', 'categories');

        TwitterCard::setTitle('emirgokkaya_');
        TwitterCard::setSite('@emirgokkaya_');


        $categories = NewsByCategory::with(['news' => function($query) {
            $query->where('state', 1)->where('block', 1);
        }])->paginate(6);


        return view('categories')->with('categories', $categories);
    }

    public function category_blogs($slug)
    {
        $blogs = News::where('state', 1)->where('block', 1)->whereHas('category', function ($query) use ($slug) {
            return $query->where('slug', $slug);
        })->orderBy('created_at', 'DESC')->paginate(7);

        $category_name = NewsByCategory::whereSlug($slug)->firstOrFail()->name;
        $category_slug = NewsByCategory::whereSlug($slug)->firstOrFail()->slug;


        SEOMeta::setTitle($category_name);
        SEOMeta::setDescription($category_name . ' kategorisine ait bloglar');
        SEOMeta::addMeta('category:section', $category_name, 'property');
        SEOMeta::addKeyword($category_name);

        OpenGraph::setDescription($category_name . ' kategorisine ait bloglar');
        OpenGraph::setTitle($category_name);
        OpenGraph::setUrl(route('category_blogs', ['slug', $category_slug]));
        OpenGraph::addProperty('type', 'category_blogs');
        OpenGraph::addProperty('locale', 'tr-TR');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        TwitterCard::setTitle('emirgokkaya_');
        TwitterCard::setSite('@emirgokkaya_');

        return view('blogs')->with('blogs', $blogs)->with('category_name', $category_name);
    }

    public function user_blogs($name, $id)
    {
        $blogs = News::where('state', 1)->where('block', 1)->whereHas('user', function ($query) use ($name, $id) {
            return $query->where('name', $name)->where('id', $id)->where('verified', 1);
        })->orderBy('created_at', 'DESC')->paginate(7);

        $user = \App\User::where('name', $name)->where('id', $id)->firstOrFail()->name;
        $user_id = \App\User::where('name', $name)->where('id', $id)->firstOrFail()->id;

        SEOMeta::setTitle($user);
        SEOMeta::setDescription($user . ' kullanıcısına ait içerikler');
        SEOMeta::addMeta('user:section', $user, 'property');
        SEOMeta::addKeyword($user);

        OpenGraph::setDescription($user . ' kullanıcısına ait içerikler');
        OpenGraph::setTitle($user);
        OpenGraph::setUrl(route('user_blogs', ['name' => $user, 'id' => $user_id]));
        OpenGraph::addProperty('type', 'user_blogs');
        OpenGraph::addProperty('locale', 'tr-TR');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        TwitterCard::setTitle('emirgokkaya_');
        TwitterCard::setSite('@emirgokkaya_');


        return view('blogs')->with('blogs', $blogs)->with('user_name', $user);
    }

    public function bulletin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'min:8|unique:newsletters|required|max:255|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        try {
            Mail::to($request->email)->send(new Bulletin($request->email));
        } catch (\Exception $exception) {
            return redirect()->back()->with('message', 'Bülten kayıt işlemi gerçekleştirilemedi, lütfen sonra tekrar deneyin')->with('status', 'warning');
        }

        DB::table('newsletters')->insert([
            'email' => $request->email,
            'permission' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->back()->with('message', 'Bültene kayıt işleminiz tamamlandı')->with('status', 'success');
    }

    public function bulletin_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Mail gönderilemedi', 'status' => 'error']);
        }


        $message = $_POST['message'];
        $emails = json_decode($_POST['userList']);

        if (count($emails) != 0) {
            foreach ($emails as $email) {
                Mail::to($email)->send(new MessageBulletin($email, $message));
            }
            return response()->json(['message' => 'Mail başarıyla gönderildi', 'status' => 'success']);
        } else {
            return response()->json(['message' => 'Mail adresi seçiniz', 'status' => 'warning']);
        }

    }

    public function search_post(Request $request)
    {
        if ($request->search === null) {
            return redirect()->back();
        }

        $news = News::where(function ($query) use ($request) {
            $query->where('state', 1)->where('block', 1)->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->search . '%')
                    ->orWhere('summary', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like' . '%' . $request->search);
            });
        })->orderByDESC('created_at')->paginate(10);

        return view('search-result')->with('news', $news)->with('search', $request->search);
    }
}
