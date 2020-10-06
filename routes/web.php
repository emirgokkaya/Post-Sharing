<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('index');
Route::get('/hakkimda', 'HomeController@about')->name('about');
Route::get('/bloglar', 'HomeController@blogs')->name('blogs');
Route::get('/bloglar/{slug}', 'HomeController@blog_detail')->name('blog_detail');
Route::get('/kategoriler', 'HomeController@categories')->name('categories');
Route::get('/kategoriler/bloglar/{slug}', 'HomeController@category_blogs')->name('category_blogs');
Route::get('/kullanici/bloglar/{name}/{id}', 'HomeController@user_blogs')->name('user_blogs');
Route::post('/bulten/abone-ol', 'HomeController@bulletin')->name('bulletion_post');
Route::get('/bulten/abone-ol', function () {
   return redirect()->back();
});

Route::get('/search', function () {
    return redirect()->back();
});
Route::post('/search', 'HomeController@search_post')->name('search');


Route::group(['middleware'=>'App\Http\Middleware\EditorMiddleware'], function(){
    Route::post('/comment/{news}', 'HomeController@comment_post')->name('comment-post');
    Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {
        Route::prefix('admin')->group(function() {

            Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

            Route::post('/bulten/mesaj', 'HomeController@bulletin_message')->name('bulletin_message');
            Route::get('/bulten/mesaj', function () {
                return redirect()->back();
            });

            Route::prefix('slaytlar')->group(function () {
                Route::get('/', 'SliderController@index')->name('sliders');

                Route::get('yeni-slayt', 'SliderController@addNewSlider')->name('add_slider');
                Route::post('yeni-slayt', 'SliderController@addNewSliderPost')->name('add_slider_post');

                Route::get('duzenle-slayt/{slug}', 'SliderController@editSlider')->name('edit_slider');
                Route::put('duzenle-slayt/{slug}', 'SliderController@editSliderPost')->name('edit_slider_post');

                Route::delete('sil-slayt/{id}', 'SliderController@deleteSlider')->name('delete_slider');
                Route::get('sil-slayt/{id}', function () {
                    return redirect()->route('sliders');
                });

                Route::delete('sil-tum-slatylar', 'SliderController@deleteAllSlider')->name('delete_all_slider');
                Route::get('sil-tum-slaytlar', function () {
                    return redirect()->route('sliders');
                });
            });
            Route::prefix('/yorumlar')->group(function () {
                Route::get('/', 'CommentController@index')->name('comments');

                Route::put('/yorum-duzenle/{id}', 'CommentController@update')->name('update-comment-put');
                Route::get('/yorum-duzenle/{id}', function () {
                    return redirect()->route('comments');
                });

                Route::delete('/yorum-sil/{id}', 'CommentController@delete')->name('delete-comment');
                Route::get('/yorum-sil/{id}', function () {
                    return redirect()->route('comments');
                });

                Route::delete('/tum-yorumlari-sil', 'CommentController@delete_all_comments')->name('/delete-all-comments');
                Route::get('/tum-yorumlari-sil', function () {
                    return redirect()->route('comments');
                });
            });
            Route::prefix('/kullanicilar')->group(function () {
                Route::get('/', 'UserController@index')->name('users');

                Route::get('/edit/{name}/{email}/{id}', 'UserController@show')->name('user_show');
                Route::put('/edit/{username}/{email}/{id}', 'UserController@update')->name('user_update');

                Route::delete('/delete/{name}/{email}/{id}', 'UserController@destroy')->name('delete_user');
                Route::get('/delete/{name}/{email}/{id}', function () {
                    return redirect()->back()->with('message', 'Geçersiz işlem')->with('status', 'danger');
                });

                Route::delete('/delete-all-users', 'UserController@deleteAllUsers')->name('delete_all_users');
                Route::get('/delete-all-users', function () {
                    return redirect()->back()->with('message', 'Geçersiz İşlem')->with('status', 'danger');
                });
            });
            Route::prefix('/kategoriler')->group(function () {
                Route::get('/', 'CategoryController@index')->name('category');
                Route::get('yeni-kategori', 'CategoryController@create')->name('add-category');
                Route::post('/yeni-kategori', 'CategoryController@store')->name('add-category_post');
                Route::get('duzenle-kategori/{slug}', 'CategoryController@show')->name('edit-category');
                Route::put('duzenle-kategori/{slug}', 'CategoryController@update')->name('edit-category-put');

                Route::delete('sil-kategori/{id}', 'CategoryController@destroy')->name('delete-category');
                Route::get('sil-kategori/{id}', function() {
                    return redirect()->route('category');
                });

                Route::delete('sil-tum-kategoriler', 'CategoryController@deleteAllCategory')->name('delete-all-category');
                Route::get('sil-tum-kategoriler', function () {
                    return redirect()->route('category');
                });
            });
            Route::prefix('/haberler')->group(function() {
                Route::get('/', 'NewsController@index')->name('news');

                Route::get('duzenle-haber/{slug}', function () {
                  return redirect()->back();
                });

                Route::put('duzenle-haber/{slug}', 'NewsController@update')->name('edit-news-put');

                Route::delete('sil-haber/{id}', 'NewsController@destroy')->name('delete-news');
                Route::get('sil-haber/{id}', function () {
                    return redirect()->route('news');
                });

                Route::delete('sil-tum-haber', 'NewsController@deleteAllNews')->name('delete-all-news');
                Route::get('sil-tum-haber', function () {
                    return redirect()->route('news');
                });
            });
        });
    });

    Route::prefix('editor')->group(function() {
        Route::get('/profilim', 'MyProfileController@index')->name('myprofile');
        Route::put('/profilim', 'MyProfileController@update')->name('myprofile_update');

        Route::prefix('haberlerim')->group(function() {
            Route::post('yeni-haber', 'MyNewsController@store')->name('mynewpost');
            Route::get('yeni-haber', 'MyNewsController@create');

            Route::put('duzenle-haber/{slug}', 'MyNewsController@update')->name('myupdatepost');
            Route::get('duzenle-haber/{slug}', 'MyNewsController@show')->name('myupdatepost_get');

            Route::delete('sil-haber/{id}', 'MyNewsController@destroy')->name('mydeletepost');
            Route::get('sil-haber/{id}', function () {
                return redirect()->route('myprofile');
            });

            Route::delete('tum-haberlerimi-sil', 'MyNewsController@deleteAllMyNews')->name('myallpostdelete');
            Route::get('tum-haberlerimi-sil', function () {
               return redirect()->route('myprofile')->with('message', 'Yaptığınız işlem hiç hoş değidi')->with('status', 'warning');
            });

            Route::post('like/{id}', 'HomeController@add_like')->name('add-like');
            Route::get('like/{id}', function () {
                return redirect()->back();
            });

            Route::delete('/delete/comment/{news_slug}/{id}', 'HomeController@delete_comment')->name('delete_comment');
            Route::get('/delete/comment/{news_slug}/{id}', function () {
                return redirect()->back();
            });
        });
    });

    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::get('/logout', function () {
        return redirect()->route('login');
    });
});

Route::group(['middleware' => 'App\Http\Middleware\guest'], function () {
    Route::get('/login', 'LoginController@index')->name('login');
    Route::post('/login', 'LoginController@login')->name('login_post');

    Route::post('/forgot-password', 'ForgotPasswordController@forgotPassword')->name('forgot_password');
    Route::get('/forgot-password', function () {
        return redirect()->route('login');
    });

    Route::get('change-password/{email}/{email_token}', 'ForgotPasswordController@forgotPasswordGet')->name('forgot_password_get');

    Route::post('/reset-password/{email}', 'ForgotPasswordController@changePassword')->name('change_password');
    Route::get('/reset-password/{email}', function () {
        return redirect()->route('login');
    });

    Route::get('/register', 'RegisterController@index')->name('register');
    Route::post('/register', 'RegisterController@register')->name('register_post');

    Route::get('/activate/{name}/{token}', 'VerifyEmailController@activate')->name('activate_user');
});



Route::get('/terms', function () {
    return view('admin.terms');
})->name('terms');

/*Auth::routes();*/

/*Route::get('/home', 'HomeController@index')->name('home');*/
