<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $result['data'] = Brand::all();
        return view('admin.brand', ['admin_name' => $admin_name, 'table_data' => $result['data']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_brand(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        return view('admin.add_brand', ['admin_name' => $admin_name]);
    }

    public function add_brand_handle(Request $request)
    {

        $request->validate([
            'brand_name' => 'required|unique:brands',
            'brand_slug' => 'required|unique:brands',
            'brand_logo' => 'required|mimes:jpeg,jpg,png',
        ]);

        $brand = new Brand();

        $brand->brand_name = $request->post('brand_name');
        $brand->brand_slug = $request->post('brand_slug');
        if ($request->hasFile('brand_logo')) {
            $logo = $request->file('brand_logo');
            $extension = $logo->extension();
            $logo_name = time() . '.' . $extension;
            $logo->storeAs('/public/brand_logo/', $logo_name);
            $brand->brand_logo = $logo_name;
        }
        if ($request->post('display_in_home') != null){
            $brand->display_in_home = $request->post('display_in_home')[0];
        }

        $queryStatus = $brand->save();
        if ($queryStatus > 0)
            $brand_message = "Brand inserted.";
        else $brand_message = "Error! Insert failed.";

        $request->session()->flash('alert', $brand_message);
        return redirect()->route('admin.brand');
    }

    public function delete_brand(Request $request, $brand_id)
    {
        $brand = Brand::find($brand_id);

        Storage::delete('/public/brand_logo/' . $brand->brand_logo);
        $queryStatus = $brand->delete();
        if ($queryStatus > 0)
            $brand_message = "Brand deleted.";
        else $brand_message = "Error! Delete failed.";

        $request->session()->flash('alert', $brand_message);
        return redirect()->route('admin.brand');
    }

    public function update_brand(Request $request, $brand_id)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $brand = Brand::find($brand_id);
        return view('admin.update_brand', ['admin_name' => $admin_name, 'brand' => $brand]);
    }

    public function update_brand_handle(Request $request)
    {

        $brand_id = $request->post('id');

        if ($request->hasFile('brand_logo'))
            $brand_logo_validation = 'required|mimes:jpeg,jpg,png';
        else $brand_logo_validation = '';

        $request->validate([
            'brand_name' => 'required|unique:brands,brand_name,' . $brand_id,
            'brand_slug' => 'required|unique:brands,brand_slug,' . $brand_id,
            'brand_logo' => $brand_logo_validation,
        ]);

        $brand = Brand::find($brand_id);
        // $old_brand = Brand::find($brand_id);

        $brand->brand_name = $request->post('brand_name');
        $brand->brand_slug = $request->post('brand_slug');
        if ($request->hasFile('brand_logo')) {
            $logo = $request->file('brand_logo');
            $extension = $logo->extension();
            $logo_name = time() . '.' . $extension;
            $logo->storeAs('/public/brand_logo/', $logo_name);
            Storage::delete('/public/brand_logo/' . $brand->brand_logo);
            $brand->brand_logo = $logo_name;
        }
        if ($request->post('display_in_home') != null){
            $brand->display_in_home = $request->post('display_in_home')[0];
        }
        else $brand->display_in_home = 'No';

        // khong the check neu nguoi do upload cung 1 cai logo
        // if ($old_brand == $brand){
        //     $brand_message = 'Nothing has changed!!!';
        // }
        // else {
        //     $queryStatus = $brand->update();
        //     if ($queryStatus > 0)
        //         $brand_message = "Brand updated.";
        //     else $brand_message = "Error! Update failed.";
        // }

        $queryStatus = $brand->update();
        if ($queryStatus > 0)
            $brand_message = "Brand updated.";
        else $brand_message = "Error! Update failed.";

        $request->session()->flash('alert', $brand_message);
        return redirect()->route('admin.brand');
    }

    public function change_display(Request $request, $brand_id){
        $brand = Brand::find($brand_id);

        if ($brand->display_in_home == 'Yes') $brand->display_in_home = 'No';
        else $brand->display_in_home = 'Yes';

        $queryStatus = $brand->update();
        if ($queryStatus > 0)
            $brand_message = "Brand Display updated.";
        else $brand_message = "Error! Update failed.";
        
        $request->session()->flash('alert', $brand_message);
        return redirect()->route('admin.brand');
    }

}
