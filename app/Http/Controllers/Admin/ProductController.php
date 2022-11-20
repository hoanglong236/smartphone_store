<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $result['product_data'] = Product::all();
        $result['category_data'] = DB::table('categories')->get();
        $result['brand_data'] = DB::table('brands')->get();
        return view('admin.product', ['admin_name'=>$admin_name, 'product_data'=>$result['product_data'], 'category_data'=>$result['category_data'], 'brand_data'=>$result['brand_data']]);
    }

    public function add_product(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $result['category_data'] = DB::table('categories')->get();
        $result['brand_data'] = DB::table('brands')->get();
        return view('admin.add_product', ['admin_name'=>$admin_name, 'category_data'=>$result['category_data'], 'brand_data'=>$result['brand_data']]);
    }

    public function add_product_handle(Request $request){

        $product = new Product();

        $request->validate([
            'product_name'  => 'required|unique:products',
            'product_slug'  => 'required|unique:products',
            'product_main_image' => 'required|mimes:jpeg,jpg,png',
        ]);

        $product->category_id = $request->post('category_id');
        $product->brand_id = $request->post('brand_id');
        $product->product_name = $request->post('product_name');
        $product->product_slug = $request->post('product_slug');
        if ($request->hasFile('product_main_image')) {
            $image = $request->file('product_main_image');
            $extension = $image->extension();
            $image_name = time() . '.' . $extension;
            $image->storeAs('/public/product_image/', $image_name);
            $product->product_main_image = $image_name;
        }

        $queryStatus = $product->save();
        if ($queryStatus > 0)
            $product_message = "Product inserted.";
        else $product_message = "Error! Insert failed.";

        $request->session()->flash('alert', $product_message);
        return redirect()->route('admin.product');
    }

    public function delete_product(Request $request, $product_id)
    {
        $product = Product::find($product_id);

        Storage::delete('/public/product_image/' . $product->product_main_image);
        $queryStatus = $product->delete();
        if ($queryStatus > 0)
            $product_message = "Product deleted.";
        else $product_message = "Error! Delete failed.";

        $request->session()->flash('alert', $product_message);
        return redirect()->route('admin.product');
    }

    public function update_product(Request $request, $product_id)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $product = Product::find($product_id);
        $result['category_data'] = DB::table('categories')->get();
        $result['brand_data'] = DB::table('brands')->get();
        return view('admin.update_product', ['admin_name'=>$admin_name, 'product'=>$product, 'category_data'=>$result['category_data'], 'brand_data'=>$result['brand_data']]);
    }

    public function update_product_handle(Request $request){

        $product_id = $request->post('id');

        if ($request->hasFile('product_main_image'))
            $product_main_image_validation = 'required|mimes:jpeg,jpg,png';
        else $product_main_image_validation = '';

        $request->validate([
            'product_name'  => 'required|unique:products,product_name,'. $product_id,
            'product_slug'  => 'required|unique:products,product_slug,'. $product_id,
            'product_main_image' => $product_main_image_validation,
        ]);
       
        $product = Product::find($product_id);
        // $old_product = Product::where(['id'=>$product_id])->first();

        $product->category_id = $request->post('category_id');
        $product->brand_id = $request->post('brand_id');
        $product->product_name = $request->post('product_name');
        $product->product_slug = $request->post('product_slug');
        if ($request->hasFile('product_main_image')) {
            $image = $request->file('product_main_image');
            $extension = $image->extension();
            $image_name = time() . '.' . $extension;
            $image->storeAs('/public/product_image/', $image_name);
            Storage::delete('/public/product_image/' . $product->product_main_image);
            $product->product_main_image = $image_name;
        }

        // because we can't check the old image is different from the new one
        // if ($old_product == $product){
        //     $product_message = "Nothing has changed!!!";
        // }
        // else {
        //     $queryStatus = $product->update();
        //     if ($queryStatus > 0)
        //         $product_message = "Product updated.";
        //     else $product_message = "Error! Update failed.";
        // }

        $queryStatus = $product->update();
        if ($queryStatus > 0)
            $product_message = "Product updated.";
        else $product_message = "Error! Update failed.";

        $request->session()->flash('alert', $product_message);
        return redirect()->route('admin.product');
    }
}
