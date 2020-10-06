<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::with('user')->get();
        return view('admin.pages.sliders')->with('sliders', $sliders);
    }

    public function addNewSlider()
    {
        return view('admin.pages.add-slider');
    }

    public function addNewSliderPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'title' => 'min:5|max:200|required',
           'image' => 'required|image|mimes:jpeg,png,jpg|max:204',
            'description' => 'required|min:10|max:500',
            'state' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if ($files = $request->file('image')) {
            $image = $request->file('image');
            $filename = time().$image->getClientOriginalExtension();
            $path = asset('images/sliders/'.$filename.'.jpg');
            $resize_image = asset('images/sliders/resize/' . $filename . '.jpg');
            Image::make($image->getRealPath())->save(public_path('images/sliders/'.$filename.'.jpg'));
            Image::make($image->getRealPath())->resize(528, 528)->save(public_path('images/sliders/resize/'.$filename.'.jpg'));

            $slider = new Slider();
            $slider->title = $request->title;
            $slider->description = $request->description;
            $slider->state = $request->state == 'active' ? true : false ;
            $slider->user_id = auth()->user()->id;
            $slider->image =  $path;
            $slider->resize_image = $resize_image;

            $slider->save();
            return redirect()->route('sliders')->with('message', 'Slayt kaydı tamamlandı')->with('status', 'success');
        } else {
            return redirect()->back()->with('message', 'Slayt resmi bulunamadı')->with('status', 'warning');
        }

    }



    public function editSlider($slug)
    {
        $slider = Slider::whereSlug($slug)->first();
        return view('admin.pages.edit-slider')->with('slider', $slider);
    }

    public function editSliderPost(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'min:5|max:200',
            'description' => 'required|min:10|max:500',
            'image' => 'image|mimes:jpeg,png,jpg|max:204',
            'state' => ''
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $slider = Slider::whereSlug($slug)->firstOrFail();
        $slider->slug = null;

        if ($files = $request->file('image')) {
            $image = $request->file('image');
            $filename = time() . $image->getClientOriginalExtension();
            $path = asset('images/sliders/' . $filename . '.jpg');
            $resize_image = asset('images/sliders/resize/' . $filename . '.jpg');
            Image::make($image->getRealPath())->save(public_path('images/sliders/' . $filename . '.jpg'));
            Image::make($image->getRealPath())->resize(528, 528)->save(public_path('images/sliders/resize/' . $filename . '.jpg'));

            $slider->image = $path;
            $slider->resize_image = $resize_image;
        }

        if ($request->state != null) {
            $slider->state = $request->state == 'active' ? true : false ;
        }

        if ($request->description != $slider->description) $slider->description = $request->description;

        $slider->update();

        return redirect()->route('sliders')->with('message', 'Slayt güncellendi')->with('status', 'info');
    }

    public function deleteSlider(Request $request)
    {
        Slider::where('id', $request->id)->delete();

        return redirect()->route('sliders')->with('message', 'Slayt başarılı bir şekilde silindi')->with('status', 'info');
    }

    public function deleteAllSlider()
    {
        Slider::truncate();
        return redirect()->route('sliders')->with('message', 'Tüm slaytlar başarılı bir şekilde silindi')->with('status', 'info');
    }
}
