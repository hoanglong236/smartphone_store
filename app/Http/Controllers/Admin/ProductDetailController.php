<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $product_id)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $product = Product::find($product_id);
        $result['category_data'] = DB::table('categories')->get();
        $result['brand_data'] = DB::table('brands')->get();
        $result['detail_data'] = DB::table('product_details')->where('product_id', '=', $product_id)->get();
        $result['image_data'] = DB::table('product_images')->where('product_id', '=', $product_id)->get();

        return view('admin.product_detail', ['admin_name' => $admin_name, 'product' => $product, 
                                            'category_data' => $result['category_data'], 
                                            'brand_data' => $result['brand_data'], 
                                            'detail_data' => $result['detail_data'],
                                            'image_data' => $result['image_data']
                                        ]);
    }

    public function add_product_detail(Request $request, $product_id)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        return view('admin.add_product_detail', ['admin_name' => $admin_name, 'product_id' => $product_id]);
    }

    public function add_product_detail_handle(Request $request)
    {

        $product_detail = new ProductDetail();

        $request->validate([
            'SKU'  => 'required',
        ]);

        $product_detail->product_id = $request->post('product_id');
        $product_detail->SKU = $request->post('SKU');
        $product_detail->quantity = $request->post('quantity');
        $product_detail->price = $request->post('price');
        $product_detail->discount_percent = $request->post('discount_percent');
        $product_detail->warranty_period = $request->post('warranty_period');
        $product_detail->short_desc = $request->post('short_desc');

        $queryStatus = $product_detail->save();
        if ($queryStatus > 0)
            $product_detail_message = "Product Detail inserted.";
        else $product_detail_message = "Error! Insert failed.";

        $request->session()->flash('alert', $product_detail_message);
        return redirect()->route('admin.product_detail', [$product_detail->product_id]);
    }

    public function add_product_detail_option(Request $request, $product_detail_id)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $product_detail = ProductDetail::find($product_detail_id);
        return view('admin.add_product_detail_option', ['admin_name' => $admin_name, 'product_detail' => $product_detail]);
    }

    public function add_product_detail_option_handle(Request $request)
    {

        $product_detail_id = $request->post('id');
        $product_detail = ProductDetail::find($product_detail_id);

        $product_option_name_1_validation = '';
        $product_option_value_1_validation = '';
        $product_option_name_2_validation = '';
        $product_option_value_2_validation = '';
        $product_option_name_3_validation = '';
        $product_option_value_3_validation = '';

        if ($product_detail->product_option_name_1 == null) {
            $product_option_name_1_validation = 'required';
            $product_option_value_1_validation = 'required';
        } else if ($product_detail->product_option_name_2 == null) {
            $product_option_name_1_validation = '';
            $product_option_value_1_validation = '';
            $product_option_name_2_validation = 'required';
            $product_option_value_2_validation = 'required';
        } else if ($product_detail->product_option_name_3 == null) {
            $product_option_name_1_validation = '';
            $product_option_value_1_validation = '';
            $product_option_name_2_validation = '';
            $product_option_value_2_validation = '';
            $product_option_name_3_validation = 'required';
            $product_option_value_3_validation = 'required';
        }

        $request->validate(
            [
                'product_option_name_1' => $product_option_name_1_validation,
                'product_option_value_1' => $product_option_value_1_validation,
                'product_option_name_2' => $product_option_name_2_validation,
                'product_option_value_2' => $product_option_value_2_validation,
                'product_option_name_3' => $product_option_name_3_validation,
                'product_option_value_3' => $product_option_value_3_validation,
                'SKU'  => 'required',
            ],
            [
                'SKU.required' => 'The SKU field is required.',
            ]
        );

        if ($request->has('product_option_name_3')) {
            $product_detail->product_option_name_3 = $request->post('product_option_name_3');
            $product_detail->product_option_value_3 = $request->post('product_option_value_3');
        } else if ($request->has('product_option_name_2')) {
            $product_detail->product_option_name_2 = $request->post('product_option_name_2');
            $product_detail->product_option_value_2 = $request->post('product_option_value_2');
        } else if ($request->has('product_option_name_1')) {
            $product_detail->product_option_name_1 = $request->post('product_option_name_1');
            $product_detail->product_option_value_1 = $request->post('product_option_value_1');
        }
        $product_detail->SKU = $request->post('SKU');
        $product_detail->quantity = $request->post('quantity');
        $product_detail->price = $request->post('price');
        $product_detail->discount_percent = $request->post('discount_percent');
        $product_detail->warranty_period = $request->post('warranty_period');
        $product_detail->short_desc = $request->post('short_desc');

        $queryStatus = $product_detail->update();
        if ($queryStatus > 0)
            $product_detail_option_message = "Product Detail Option inserted.";
        else $product_detail_option_message = "Error! Insert failed.";

        $request->session()->flash('alert', $product_detail_option_message);
        return redirect()->route('admin.product_detail', [$product_detail->product_id]);
    }

    public function delete_product_detail_option(Request $request, $product_detail_id)
    {
        $product_detail = ProductDetail::find($product_detail_id);
        $product_id = $product_detail->product_id;

        $queryStatus = $product_detail->delete();
        if ($queryStatus > 0)
            $product_detail_message = "Product Detail deleted.";
        else $product_detail_message = "Error! Delete failed.";

        $request->session()->flash('alert', $product_detail_message);
        return redirect()->route('admin.product_detail', [$product_id]);
    }

    public function update_product_detail(Request $request, $product_detail_id)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $product_detail = ProductDetail::find($product_detail_id);
        return view('admin.update_product_detail', ['admin_name' => $admin_name, 'product_detail' => $product_detail]);
    }

    public function update_product_detail_handle(Request $request)
    {

        $product_detail_id = $request->post('id');

        $request->validate([
            'SKU'  => 'required',
        ]);

        $product_detail = ProductDetail::find($product_detail_id);

        $product_detail->product_id = $request->post('product_id');
        $product_detail->SKU = $request->post('SKU');
        $product_detail->quantity = $request->post('quantity');
        $product_detail->price = $request->post('price');
        $product_detail->discount_percent = $request->post('discount_percent');
        $product_detail->warranty_period = $request->post('warranty_period');
        $product_detail->short_desc = trim($request->post('short_desc'));

        $queryStatus = $product_detail->update();
        if ($queryStatus > 0)
            $product_detail_message = "Product Detail updated.";
        else $product_detail_message = "Error! Update failed.";

        $request->session()->flash('alert', $product_detail_message);
        return redirect()->route('admin.product_detail', [$product_detail->product_id]);
    }

    public function add_product_detail_option_value(Request $request, $product_detail_id)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $product_detail = ProductDetail::find($product_detail_id);
        return view('admin.add_product_detail_option_value', ['admin_name' => $admin_name, 'product_detail' => $product_detail]);
    }

    public function add_product_detail_option_value_handle(Request $request)
    {
        $old_product_detail_id = $request->post('id');
        $old_product_detail = ProductDetail::find($old_product_detail_id);

        $product_option_value_1_validation = '';
        $product_option_value_2_validation = '';
        $product_option_value_3_validation = '';

        if ($request->post('product_option_value_3') != null) {
            
            $product_detail_one_pair = DB::table('product_details')->where('product_id', '=', $request->post('product_id'))
                                            ->where('product_option_name_1', '=', $request->post('product_option_name_1'))
                                            ->where('product_option_value_1', '=', $request->post('product_option_value_1'))->get();
            if ($product_detail_one_pair->isEmpty()){
                $product_option_value_1_validation = 'required';
                $product_option_value_2_validation = 'required';
                $product_option_value_3_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                    return $query->where('product_id', $request->post('product_id'))
                                ->where('product_option_value_1', $request->post('product_option_value_1'))
                                ->where('product_option_value_2', $request->post('product_option_value_2'))
                                ->where('product_option_value_3', $request->post('product_option_value_3'));
                });
            }
            else{
                $product_detail_two_pair_type_1 = DB::table('product_details')->where('product_id', $request->post('product_id'))
                                ->where('product_option_name_1', '=', $request->post('product_option_name_1'))
                                ->where('product_option_value_1', '=', $request->post('product_option_value_1'))
                                ->where('product_option_name_2', '=', $request->post('product_option_name_2'))->get();
                $product_detail_two_pair_type_2 = DB::table('product_details')->where('product_id', $request->post('product_id'))
                                ->where('product_option_name_1', '=', $request->post('product_option_name_1'))
                                ->where('product_option_value_1', '=', $request->post('product_option_value_1'))
                                ->where('product_option_name_2', '!=', $request->post('product_option_name_2'))->get();
                $product_detail_two_pair_type_3 = DB::table('product_details')->where('product_id', $request->post('product_id'))
                                ->where('product_option_name_1', '=', $request->post('product_option_name_1'))
                                ->where('product_option_value_1', '=', $request->post('product_option_value_1'))
                                ->where('product_option_name_2', '=', $request->post('product_option_name_2'))
                                ->where('product_option_value_2', '=', $request->post('product_option_value_2'))->get();
                if ($product_detail_two_pair_type_1->isEmpty() && $product_detail_two_pair_type_2->isEmpty()){
                    // ok
                    $product_option_value_1_validation = 'required';
                    $product_option_value_2_validation = 'required';
                    $product_option_value_3_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                        return $query->where('product_id', $request->post('product_id'))
                                    ->where('product_option_value_1', $request->post('product_option_value_1'))
                                    ->where('product_option_value_2', $request->post('product_option_value_2'))
                                    ->where('product_option_value_3', $request->post('product_option_value_3'));
                    });
                }
                else {
                    if ($product_detail_two_pair_type_2->isNotEmpty()){
                        // validation
                        $product_option_value_1_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                            return $query->where('product_id', $request->post('product_id'))
                                        ->where('product_option_value_1', $request->post('product_option_value_1'));
                        });
                    }
                    else {
                        if ($product_detail_two_pair_type_3->isEmpty()){
                            // ok
                            $product_option_value_1_validation = 'required';
                            $product_option_value_2_validation = 'required';
                            $product_option_value_3_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                                return $query->where('product_id', $request->post('product_id'))
                                            ->where('product_option_value_1', $request->post('product_option_value_1'))
                                            ->where('product_option_value_2', $request->post('product_option_value_2'))
                                            ->where('product_option_value_3', $request->post('product_option_value_3'));
                            });
                        }
                        else {
                            $product_detail_three_pair_type_1 = DB::table('product_details')->where('product_id', $request->post('product_id'))
                                    ->where('product_option_name_1', '=', $request->post('product_option_name_1'))
                                    ->where('product_option_value_1', '=', $request->post('product_option_value_1'))
                                    ->where('product_option_name_2', '=', $request->post('product_option_name_2'))
                                    ->where('product_option_value_2', '=', $request->post('product_option_value_2'))
                                    ->where('product_option_name_3', '=', $request->post('product_option_name_3'))->get();
                            $product_detail_three_pair_type_2 = DB::table('product_details')->where('product_id', $request->post('product_id'))
                                    ->where('product_option_name_1', '=', $request->post('product_option_name_1'))
                                    ->where('product_option_value_1', '=', $request->post('product_option_value_1'))
                                    ->where('product_option_name_2', '=', $request->post('product_option_name_2'))
                                    ->where('product_option_value_2', '=', $request->post('product_option_value_2'))
                                    ->where('product_option_name_3', '!=', $request->post('product_option_name_3'))->get();
                            if ($product_detail_three_pair_type_1->isEmpty() && $product_detail_three_pair_type_2->isEmpty()){
                                // ok
                                $product_option_value_1_validation = 'required';
                                $product_option_value_2_validation = 'required';
                                $product_option_value_3_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                                    return $query->where('product_id', $request->post('product_id'))
                                                ->where('product_option_value_1', $request->post('product_option_value_1'))
                                                ->where('product_option_value_2', $request->post('product_option_value_2'))
                                                ->where('product_option_value_3', $request->post('product_option_value_3'));
                                });
                            }
                            else {
                                if ($product_detail_three_pair_type_2->isNotEmpty()){
                                    // validation
                                    $product_option_value_1_validation = 'required';
                                    $product_option_value_2_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                                        return $query->where('product_id', $request->post('product_id'))
                                                    ->where('product_option_value_1', $request->post('product_option_value_1'))
                                                    ->where('product_option_value_2', $request->post('product_option_value_2'));
                                    });
                                }
                                else {
                                    // ok
                                    $product_option_value_1_validation = 'required';
                                    $product_option_value_2_validation = 'required';
                                    $product_option_value_3_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                                        return $query->where('product_id', $request->post('product_id'))
                                                    ->where('product_option_value_1', $request->post('product_option_value_1'))
                                                    ->where('product_option_value_2', $request->post('product_option_value_2'))
                                                    ->where('product_option_value_3', $request->post('product_option_value_3'));
                                    });
                                }
                            }
                        }
                    }
                }
            }
        } else if ($request->post('product_option_name_2') != null) {
            // it's unique (option_value_value_1, product_id)
            $product_detail_with_3_duplicate_in_order = DB::table('product_details')->where('product_id', $request->post('product_id'))
                                                ->where('product_option_name_1', $request->post('product_option_name_1'))
                                                ->where('product_option_value_1', $request->post('product_option_value_1'))
                                                ->where('product_option_name_2', $request->post('product_option_name_2'))->get();
            if ($product_detail_with_3_duplicate_in_order->isNotEmpty()){
                $product_option_value_1_validation = 'required';
                $product_option_value_2_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                    return $query->where('product_id', $request->post('product_id'))->where('product_option_value_1', $request->post('product_option_value_1'))->where('product_option_value_2', $request->post('product_option_value_2'));
                });
            }
            else {
                $product_detail_with_2_duplicate_in_order = DB::table('product_details')->where('product_id', $request->post('product_id'))
                                                ->where('product_option_name_1', $request->post('product_option_name_1'))
                                                ->where('product_option_value_1', $request->post('product_option_value_1'))->get();
                                                // option name 2 chi co 1, TH khac option name 2 va co nhieu field
                if ($product_detail_with_2_duplicate_in_order->isNotEmpty()){
                    if ($product_detail_with_2_duplicate_in_order->count() == 1){// option name 2 la null hoac khac option name 2
                        if ($product_detail_with_2_duplicate_in_order->first()->product_option_name_2 != null)
                            $product_option_value_1_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                                return $query->where('product_id', $request->post('product_id'))
                                            ->where('product_option_value_1', $request->post('product_option_value_1'));
                            });
                        else {
                            $product_option_value_1_validation = 'required';
                            $product_option_value_2_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                                return $query->where('product_id', $request->post('product_id'))->where('product_option_value_1', $request->post('product_option_value_1'))->where('product_option_value_2', $request->post('product_option_value_2'));
                            });
                        }
                    }
                    else {// co nhieu field thi chi co the la khac option name 2
                        $product_option_value_1_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                            return $query->where('product_id', $request->post('product_id'))
                                        ->where('product_option_value_1', $request->post('product_option_value_1'));
                        });
                    }
                }
                else {
                    $product_option_value_1_validation = 'required';
                    $product_option_value_2_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                        return $query->where('product_id', $request->post('product_id'))
                                    ->where('product_option_value_1', $request->post('product_option_value_1'))
                                    ->where('product_option_value_2', $request->post('product_option_value_2'));
                    });
                }
            }
        } else {
            $product_option_value_1_validation = Rule::unique('product_details')->where(function ($query) use ($request) {
                return $query->where('product_id', $request->post('product_id'))->where('product_option_value_1', $request->post('product_option_value_1'));
            });
        }

        $request->validate( //need optimize
            [
                'product_option_value_1' => $product_option_value_1_validation,
                'product_option_value_2' => $product_option_value_2_validation,
                'product_option_value_3' => $product_option_value_3_validation,
                'SKU'  => 'required',
            ],
            [
                'SKU.required' => 'The SKU field is required.',
            ]
        );

        $product_detail = new ProductDetail();

        $product_detail->product_id = $old_product_detail->product_id;
        if ($request->has('product_option_name_3')) {
            $product_detail->product_option_name_3 = $request->post('product_option_name_3');
            $product_detail->product_option_value_3 = $request->post('product_option_value_3');
        }
        if ($request->has('product_option_name_2')) {
            $product_detail->product_option_name_2 = $request->post('product_option_name_2');
            $product_detail->product_option_value_2 = $request->post('product_option_value_2');
        }
        if ($request->has('product_option_name_1')) {
            $product_detail->product_option_name_1 = $request->post('product_option_name_1');
            $product_detail->product_option_value_1 = $request->post('product_option_value_1');
        }
        $product_detail->SKU = $request->post('SKU');
        $product_detail->quantity = $request->post('quantity');
        $product_detail->price = $request->post('price');
        $product_detail->discount_percent = $request->post('discount_percent');
        $product_detail->warranty_period = $request->post('warranty_period');
        $product_detail->short_desc = $request->post('short_desc');

        // print_r($product_detail); die();

        $queryStatus = $product_detail->save();
        if ($queryStatus > 0)
            $product_detail_option_message = "Product Detail Option inserted.";
        else $product_detail_option_message = "Error! Insert failed.";

        $request->session()->flash('alert', $product_detail_option_message);
        return redirect()->route('admin.product_detail', [$product_detail->product_id]);
    }

    // image start here

    public function add_product_images(Request $request, $product_id){
        $admin_name = $request->session()->get('ADMIN_NAME');
        $image_data = DB::table('product_images')->where('product_id', $product_id)->get();
        return view('admin.add_product_images', ['admin_name' => $admin_name, 'image_data' => $image_data, 'product_id' => $product_id]);
    }

    public function add_product_images_handle(Request $request){

        $request->validate([
            'image' => 'required',
            'image.*' => 'mimes:jpeg,jpg,png',
        ]);

        $product_id = $request->post('product_id');
        
        $queryStatus = 0;

        if ($request->hasFile('image')) {
            $images = $request->file('image');

            $count = 0;

            foreach ($images as $image) {
                print_r($image);
                $product_image = new ProductImage();
                $product_image->product_id = $product_id;

                $extension = $image->extension();
                // ko co count thi cac image se bi cung thoi gian vi dong lenh for nay thoi gian chay rat thap
                $count++; // increment
                $image_name = time() . $count . '.' . $extension;

                $image->storeAs('/public/product_image/', $image_name);
                $product_image->image = $image_name;

                $queryStatus = $product_image->save();
            }
            // die();
        }

        if ($queryStatus > 0)
            $product_image_message = "Product Images inserted.";
        else $product_image_message = "Error! Insert failed.";
        $request->session()->flash('alert', $product_image_message);
        return redirect()->route('admin.product_detail', [$product_id]);
    }

    public function delete_product_image(Request $request, $product_image_id){
        $product_image = ProductImage::find($product_image_id);
        $product_id = $product_image->product_id;

        Storage::delete('/public/product_image/' . $product_image->image);
        $queryStatus = $product_image->delete();
        if ($queryStatus > 0)
            $product_image_message = "Product Image deleted.";
        else $product_image_message = "Error! Delete failed.";

        $request->session()->flash('alert', $product_image_message);
        return redirect()->route('admin.product_detail', [$product_id]);
    }



    // public function update_product(Request $request, $product_id)
    // {
    //     $admin_name = $request->session()->get('ADMIN_NAME');
    //     $product = Product::find($product_id);
    //     $result['category_data'] = DB::table('categories')->get();
    //     $result['brand_data'] = DB::table('brands')->get();
    //     return view('admin.update_product', ['admin_name'=>$admin_name, 'product'=>$product, 'category_data'=>$result['category_data'], 'brand_data'=>$result['brand_data']]);
    // }

    // public function update_product_handle(Request $request){

    //     $product_id = $request->post('id');

    //     if ($request->hasFile('product_main_image'))
    //         $product_main_image_validation = 'required|mimes:jpeg,jpg,png';
    //     else $product_main_image_validation = '';

    //     $request->validate([
    //         'product_name'  => 'required|unique:products,product_name,'. $product_id,
    //         'product_slug'  => 'required|unique:products,product_slug,'. $product_id,
    //         'product_main_image' => $product_main_image_validation,
    //     ]);

    //     $product = Product::find($product_id);

    //     $product->category_id = $request->post('category_id');
    //     $product->brand_id = $request->post('brand_id');
    //     $product->product_name = $request->post('product_name');
    //     $product->product_slug = $request->post('product_slug');
    //     if ($request->hasFile('product_main_image')) {
    //         $image = $request->file('product_main_image');
    //         $extension = $image->extension();
    //         $image_name = time() . '.' . $extension;
    //         $image->storeAs('/public/product_image/', $image_name);
    //         Storage::delete('/public/product_image/' . $product->product_main_image);
    //         $product->product_main_image = $image_name;
    //     }

    //     $queryStatus = $product->update();
    //     if ($queryStatus > 0)
    //         $product_message = "Product updated.";
    //     else $product_message = "Error! Update failed.";

    //     $request->session()->flash('alert', $product_message);
    //     return redirect()->route('admin.product');
    // }
}
