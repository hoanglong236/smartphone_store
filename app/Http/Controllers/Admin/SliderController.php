<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $result['sliders'] = Slider::all();
        foreach($result['sliders'] as $slider){
            $category_slug = $slider->category_slug;
            $category = DB::table('categories')->where('category_slug', '=', $category_slug)->first();
            $result[$slider->id]['category_name'] = $category->category_name;
        }
        return view('admin.slider', ['admin_name'=>$admin_name, 'result'=>$result]);
    }

    public function add_slider(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $categories = Category::all();
        return view('admin.add_slider', ['admin_name'=>$admin_name, 'categories'=>$categories]);
    }

    public function add_slider_handle(Request $request){

        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png',
        ]);

        $slider = new Slider();

        $slider->title = $request->post('title');
        $slider->discount_title = $request->post('discount_title');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            $image_name = time() . '.' . $extension;
            $image->storeAs('/public/slider_image/', $image_name);
            $slider->image = $image_name;
        }
        $slider->category_slug = $request->post('category_slug');
        
        $queryStatus = $slider->save();
        if ($queryStatus > 0)
            $slider_message = "Slider inserted.";
        else $slider_message = "Error! Insert failed.";

        $request->session()->flash('alert', $slider_message);
        return redirect()->route('admin.slider');
    }

    public function delete_slider(Request $request, $slider_id)
    {
        $slider = Slider::find($slider_id);

        Storage::delete('/public/slider_image/' . $slider->image);
        $queryStatus = $slider->delete();
        if ($queryStatus > 0)
            $slider_message = "Slider deleted.";
        else $slider_message = "Error! Delete failed.";
        
        $request->session()->flash('alert', $slider_message);
        return redirect()->route('admin.slider');
    }

    public function update_slider(Request $request, $slider_id)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $slider = Slider::find($slider_id);
        $categories = Category::all();
        return view('admin.update_slider', ['admin_name'=>$admin_name, 'slider'=>$slider, 'categories'=>$categories]);
    }

    public function update_slider_handle(Request $request){
        $slider_id = $request->post('slider_id');

        if ($request->hasFile('image'))
            $slider_image_validation = 'required|mimes:jpeg,jpg,png';
        else $slider_image_validation = '';

        $request->validate([
            'image' => $slider_image_validation,
        ]);
        
        $slider = Slider::find($slider_id);
        $slider->title = $request->post('title');
        $slider->discount_title = $request->post('discount_title');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            $image_name = time() . '.' . $extension;
            $image->storeAs('/public/slider_image/', $image_name);
            Storage::delete('/public/slider_image/' . $slider->image);
            $slider->image = $image_name;
        }
        $slider->category_slug = $request->post('category_slug');

        $queryStatus = $slider->update();
        if ($queryStatus > 0)
            $slider_message = "Slider updated.";
        else $slider_message = "Error! Update failed.";

        $request->session()->flash('alert', $slider_message);
        return redirect()->route('admin.slider');
    }
}
