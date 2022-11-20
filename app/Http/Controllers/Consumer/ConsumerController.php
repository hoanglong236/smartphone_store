<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\CartDetail;
use App\Models\CustomerAddress;
use App\Models\ProductDetail;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Category;
use App\Models\Slider;


class ConsumerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    { 
        $result['categories_display'] = DB::table('categories')->where('display_in_home', '=', 'Yes')->limit(4)->get();
        foreach ($result['categories_display'] as $category_display){
            $result['products_display'][$category_display->id]  = DB::table('products')->where('category_id', '=', $category_display->id)->limit(8)->get();
            foreach ($result['products_display'][$category_display->id] as $product_display){
                $result['product_details'][$product_display->id] = DB::table('product_details')->where('product_id', '=', $product_display->id)->first();
            }
        }
        $result['brands_display'] = DB::table('brands')->where('display_in_home', '=', 'Yes')->limit(10)->get();
        $result['sliders'] = Slider::all();
        // product phai la detail de co gia tien
        // can lam chuc nang best selling
        $customer_name = "";
        if ($request->session()->has('CUSTOMER_NAME')){
            $customer_name = $request->session()->get('CUSTOMER_NAME');
        }
        return view('consumer.home', ['result' => $result, 'customer_name' => $customer_name]);
    }

    public function product_detail(Request $request, $product_slug){
        $result['product'] = DB::table('products')->where('product_slug', '=', $product_slug)->first();
        $result['product_details'] = DB::table('product_details')->where('product_id', '=', $result['product']->id)->get();
        $result['product_images'] = DB::table('product_images')->where('product_id', '=', $result['product']->id)->get();
        $result['category_name'] = DB::table('categories')->where('id', '=', $result['product']->category_id)->value('category_name');
        $result['related_products'] = DB::table('products')->where('category_id', '=', $result['product']->category_id)->limit(6)->get();
        foreach ($result['related_products'] as $related_product){
            $result['first_option_related_product_detail'][$related_product->id] = DB::table('product_details')->where('product_id', '=', $related_product->id)->first();
        }
        $customer_name = "";
        if ($request->session()->has('CUSTOMER_NAME')){
            $customer_name = $request->session()->get('CUSTOMER_NAME');
        }
        return view('consumer.product_detail', ['result' => $result, 'customer_name' => $customer_name]);
    }

    public function get_product_detail_option_1(Request $request, $product_id){
        $result['option_name_1'] = DB::table('product_details')->where('product_id', '=', $product_id)
                                            ->first()->product_option_name_1;
        $result['option_value_1'] = DB::table('product_details')->where('product_id', '=', $product_id)
                                            ->distinct('product_option_value_1')->get('product_option_value_1')
                                            ->map(function($element){
                                                return  $element->product_option_value_1;
                                            });
        return response()->json(array('result'=> $result));
    }

    public function get_product_detail_option_2(Request $request, $product_id){
        $product_option_value_1 = json_decode($request->post('product_option_value_1'));
        $result['option_name_2'] = DB::table('product_details')->where('product_id', '=', $product_id)
                                            ->where('product_option_value_1', '=', $product_option_value_1)
                                            ->first()->product_option_name_2;
        $result['option_value_2'] = DB::table('product_details')->where('product_id', '=', $product_id)
                                            ->where('product_option_value_1', '=', $product_option_value_1)
                                            ->distinct('product_option_value_2')->get('product_option_value_2')
                                            ->map(function($element){
                                                return $element->product_option_value_2;
                                            });
        return response()->json(array('result'=> $result));
    }

    public function get_product_detail_option_3(Request $request, $product_id){
        $product_option_value_1 = json_decode($request->post('product_option_value_1'));
        $product_option_name_2 = json_decode($request->post('product_option_name_2'));
        $product_option_value_2 = json_decode($request->post('product_option_value_2'));

        $result['option_name_3'] = DB::table('product_details')->where('product_id', '=', $product_id)
                                                ->where('product_option_value_1', '=', $product_option_value_1)
                                                ->where('product_option_name_2', '=', $product_option_name_2)
                                                ->where('product_option_value_2', '=', $product_option_value_2)
                                                ->first()->product_option_name_3;
        $result['option_value_3'] = DB::table('product_details')->where('product_id', '=', $product_id)
                                                ->where('product_option_value_1', '=', $product_option_value_1)
                                                ->where('product_option_name_2', '=', $product_option_name_2)
                                                ->where('product_option_value_2', '=', $product_option_value_2)
                                                ->distinct('product_option_value_3')->get('product_option_value_3')
                                                ->map(function($element){
                                                    return $element->product_option_value_3;
                                                });
        return response()->json(array('result'=> $result));
    }

    public function get_product_detail(Request $request, $product_id){
        $product_option_value_1 = json_decode($request->post('product_option_value_1'));
        $product_option_name_2 = json_decode($request->post('product_option_name_2'));
        $product_option_value_2 = json_decode($request->post('product_option_value_2'));
        $product_option_name_3 = json_decode($request->post('product_option_name_3'));
        $product_option_value_3 = json_decode($request->post('product_option_value_3'));
        
        if ($product_option_value_1 != ""){
            if ($product_option_name_2 != ""){
                if ($product_option_name_3 != ""){
                    $result['product_detail'] = DB::table('product_details')->where('product_id', '=', $product_id)
                                            ->where('product_option_value_1', '=', $product_option_value_1)
                                            ->where('product_option_name_2', '=', $product_option_name_2)
                                            ->where('product_option_value_2', '=', $product_option_value_2)
                                            ->where('product_option_name_3', '=', $product_option_name_3)
                                            ->where('product_option_value_3', '=', $product_option_value_3)
                                            ->first();
                }
                else {
                    $result['product_detail'] = DB::table('product_details')->where('product_id', '=', $product_id)
                                            ->where('product_option_value_1', '=', $product_option_value_1)
                                            ->where('product_option_name_2', '=', $product_option_name_2)
                                            ->where('product_option_value_2', '=', $product_option_value_2)
                                            ->first();
                }
            }
            else {
                $result['product_detail'] = DB::table('product_details')->where('product_id', '=', $product_id)
                                            ->where('product_option_value_1', '=', $product_option_value_1)
                                            ->first();
            }
        }
        else {
            $result['product_detail'] = DB::table('product_details')->where('product_id', '=', $product_id)->first();
        }
        return response()->json(array('result'=> $result));
    }

    public function register(Request $request){
        if (!$request->session()->has('CUSTOMER_LOGIN')){
            $request->session()->put('PREVIOUS_PAGE', url()->previous());
            // print_r(url()->previous());
            // se tra ve home trong truong hop tu page detail -> register (for register)-> register (for login)
            return view('consumer.register');
        }
        else return redirect()->route('/');
    }

    public function register_handle(Request $request){

        $request->validate([
            'email'=>'required|unique:customers',
        ]);

        $customer = new Customer();
        $customer->email = $request->post('email');
        $customer->password = $request->post('password');
        $customer->firstname = $request->post('firstname');
        $customer->lastname = $request->post('lastname');
        $customer->gender = $request->post('gender');
        $customer->phone = $request->post('phone');
        if ($customer->password != $request->post('retype_password')){
            $request->session()->flash('error_mess_register', 'Please retype correct password');
            return redirect()->route('register');
        }
        $customer->password = Hash::make($customer->password);
        $queryStatus = $customer->save();

        if ($queryStatus > 0){
            $customer_message = "Register Successfully.";
        }
        else $customer_message = "Error! Register failed.";
        
        $request->session()->flash('alert', $customer_message);
        return redirect()->route('register');
    }

    public function auth(Request $request){
        $email = $request->post('email');
        $password = $request->post('password');

        $customer = Customer::where('email', '=', $email)->first();
        if (isset($customer->id)) {
            if (Hash::check($password, $customer->password)){
                $request->session()->put('CUSTOMER_LOGIN', true);
                $request->session()->put('CUSTOMER_ID', $customer->id);
                $request->session()->put('CUSTOMER_NAME', $customer->firstname);
                if ($request->session()->has('PREVIOUS_PAGE')){
                    $url = $request->session()->get('PREVIOUS_PAGE');
                    $request->session()->forget('PREVIOUS_PAGE');
                    return redirect($url);
                }
                else return redirect()->route('/');
            }
            else{
                $request->session()->flash('error_mess_login', 'Please enter correct password');
                return redirect()->route('register');
            }
        }
        else{
            $request->session()->flash('error_mess_login', 'Please enter valid login details');
            return redirect()->route('register');
        }
    }

    public function logout(Request $request){
        $request->session()->forget('CUSTOMER_LOGIN');
        $request->session()->forget('CUSTOMER_ID');
        $request->session()->forget('CUSTOMER_NAME');
        $request->session()->flash('alert', 'Logout successfully');
        return redirect()->route('/');
    }

    public function profile(Request $request){
        $customer_name = "";
        if ($request->session()->has('CUSTOMER_NAME')){
            $customer_name = $request->session()->get('CUSTOMER_NAME');
        }
        $customer_id = $request->session()->get('CUSTOMER_ID');
        $customer = DB::table('customers')->select('firstname', 'lastname', 'gender', 'phone', 'email')
                                ->where('id', '=', $customer_id)->first();
        // print_r($customer); die();
        $customer_addresses = DB::table('customer_addresses')->where('customer_id', '=', $customer_id)->get();
        return view('consumer.profile' ,['customer_name' => $customer_name, 'customer' => $customer, 'customer_addresses' => $customer_addresses]);
    }

    public function update_profile_handle(Request $request){
        $profile = $request->post('profile');
        $customer_id = $request->session()->get('CUSTOMER_ID');

        $customer = Customer::find($customer_id);

        // print_r(gettype($profile));
        $customer->firstname = $profile['firstname'];
        $customer->lastname = $profile['lastname'];
        $customer->gender = $profile['gender'];
        $customer->phone = $profile['phone'];
        $customer->email = $profile['email'];

        $queryStatus = $customer->update();
        if ($queryStatus > 0){
            $customer_message = "Customer Profile updated.";
            $request->session()->put('CUSTOMER_NAME', $customer->firstname);
        }
        else $customer_message = "Error! Update failed.";

        return response()->json(array('customer_message' => $customer_message));

        // return response()->json(array('profile' => $request->post('profile')));
    }

    public function add_address(Request $request){
        $customer_name = "";
        if ($request->session()->has('CUSTOMER_NAME')){
            $customer_name = $request->session()->get('CUSTOMER_NAME');
        }
        return view('consumer.add_address' ,['customer_name' => $customer_name]);
    }

    public function add_address_handle(Request $request){
        $customer_id = $request->session()->get('CUSTOMER_ID');

        $customer_address = new CustomerAddress();

        $customer_address->customer_id = $customer_id;
        $customer_address->ZIP_code = $request->post('ZIP_code');
        $customer_address->city_or_province = $request->post('city_or_province');
        $customer_address->district = $request->post('district');
        $customer_address->ward_or_commune = $request->post('ward_or_commune');
        $customer_address->specific_address = $request->post('specific_address');
        $customer_address->address_type = $request->post('address_type');
        if ($request->post('default_address') != null){
            $customer_address->default_address = $request->post('default_address')[0];
        }
        else $customer_address->default_address = 'No';

        $queryStatus = $customer_address->save();
        if ($queryStatus > 0)
            $customer_address_message = "Address added.";
        else $customer_address_message = "Error! Add address failed.";

        // xoa default cua cac address phia truoc la default
        // DB::table('customer_addresses')->where('customer_id', '=', $customer_id);

        $request->session()->flash('alert', $customer_address_message);
        return redirect()->route('profile');
    }

    public function add_to_cart(Request $request){
        $product_detail_id = intval(json_decode($request->post('product_detail_id')));
        $quantity = intval(json_decode($request->post('quantity')));
        if ($request->session()->has('CUSTOMER_LOGIN')){
            $customer_id = $request->session()->get('CUSTOMER_ID');
            $cart_detail = DB::table('cart_details')->where('customer_id', '=',$customer_id)
                                                ->where('product_detail_id', '=', $product_detail_id)->first();
            if ($cart_detail === null) {
                $cart = new CartDetail();
                $cart->customer_id = $customer_id;
                $cart->product_detail_id = $product_detail_id;
                $cart->quantity = $quantity;
                $queryStatus = $cart->save();
                if ($queryStatus > 0) {
                    $add_to_cart_message = "Add to cart successfully.";
                } else $add_to_cart_message = "Add to cart failed.";
            } else {
                $cart = CartDetail::find($cart_detail->id);
                $cart->quantity += $quantity;
                $queryStatus = $cart->update();
                if ($queryStatus > 0) {
                    $add_to_cart_message = "Add to cart successfully.";
                } else $add_to_cart_message = "Add to cart failed.";
            }
            return response()->json(array('is_logged_in' => true, 'add_to_cart_mess' => $add_to_cart_message));
        }
        return response()->json(array('is_logged_in' => false));
    }

    public function cart(Request $request){
        $customer_name = $request->session()->get('CUSTOMER_NAME');

        $customer_id = $request->session()->get('CUSTOMER_ID');
        $cart_details =  CartDetail::where('customer_id', '=', $customer_id)->get();
        $result['cart_detail_ids'] = $cart_details->map(function ($cart_detail){
            return $cart_detail->id;
        });

        foreach ($cart_details as $cart_detail){
            $cart_detail_id = $cart_detail->id;
            $result[$cart_detail_id]['quantity'] = $cart_detail->quantity;

            $product_detail = ProductDetail::find($cart_detail->product_detail_id);
            $result[$cart_detail_id]['product_detail_id'] = $product_detail->id;
            $result[$cart_detail_id]['stock_quantity'] = $product_detail->quantity;
            $result[$cart_detail_id]['product_option_name_1'] = $product_detail->product_option_name_1;
            $result[$cart_detail_id]['product_option_value_1'] = $product_detail->product_option_value_1;
            $result[$cart_detail_id]['product_option_name_2'] = $product_detail->product_option_name_2;
            $result[$cart_detail_id]['product_option_value_2'] = $product_detail->product_option_value_2;
            $result[$cart_detail_id]['product_option_name_3'] = $product_detail->product_option_name_3;
            $result[$cart_detail_id]['product_option_value_3'] = $product_detail->product_option_value_3;
            $result[$cart_detail_id]['price'] = $product_detail->price * (100 - $product_detail->discount_percent) / 100;
            
            $product = Product::find($product_detail->product_id);
            $result[$cart_detail_id]['name'] = $product->product_name;
            $result[$cart_detail_id]['image'] = $product->product_main_image;
        }
       
        return view('consumer.cart', ['customer_name' => $customer_name, 'result' => $result]);
    }

    public function get_stock_quantity(Request $request, $product_detail_id){
        return response()->json(array('stock_quantity' => ProductDetail::find($product_detail_id)->quantity));
    }

    public function delete_cart_detail(Request $request, $cart_detail_id){
        $cart_detail = CartDetail::find($cart_detail_id);

        $queryStatus = $cart_detail->delete();
        if ($queryStatus > 0)
            $cart_detail_message = "Item deleted.";
        else $cart_detail_message = "Error! Delete failed.";

        return response()->json(array('cart_detail_message' => $cart_detail_message));
    }

    public function update_cart_detail_quantity(Request $request, $cart_detail_id, $quantity){
        $cart_detail = CartDetail::find($cart_detail_id);

        $cart_detail->quantity = $quantity;

        $queryStatus = $cart_detail->update();
        if ($queryStatus > 0)
            $cart_detail_message = "Item quantity updated.";
        else $cart_detail_message = "Error! Update failed.";

        return response()->json(array('cart_detail_message' => $cart_detail_message));
    }

    public function create_session_checkout(Request $request){
        $cart_detail_ids = json_decode($request->post('cart_item_ids'));

        $request->session()->forget('CHECKOUT');
        $request->session()->put('CHECKOUT', $cart_detail_ids);

        return response()->json(array('checkout_session_mess' => "created"));
    }

    public function checkout(Request $request){
        $customer_name = $request->session()->get('CUSTOMER_NAME');
        
        if (!$request->session()->exists('CHECKOUT')){
            return redirect()->route('cart');
        }
        $result['cart_detail_ids'] = $request->session()->get('CHECKOUT');
        $request->session()->forget('CHECKOUT');
        
        foreach ($result['cart_detail_ids'] as $cart_detail_id){
            $cart_detail = CartDetail::find($cart_detail_id);
            $result[$cart_detail_id]['quantity'] = $cart_detail->quantity;

            $product_detail = ProductDetail::find($cart_detail->product_detail_id);
            $result[$cart_detail_id]['product_detail_id'] = $product_detail->id;
            $result[$cart_detail_id]['stock_quantity'] = $product_detail->quantity;
            $result[$cart_detail_id]['product_option_name_1'] = $product_detail->product_option_name_1;
            $result[$cart_detail_id]['product_option_value_1'] = $product_detail->product_option_value_1;
            $result[$cart_detail_id]['product_option_name_2'] = $product_detail->product_option_name_2;
            $result[$cart_detail_id]['product_option_value_2'] = $product_detail->product_option_value_2;
            $result[$cart_detail_id]['product_option_name_3'] = $product_detail->product_option_name_3;
            $result[$cart_detail_id]['product_option_value_3'] = $product_detail->product_option_value_3;
            $result[$cart_detail_id]['price'] = $product_detail->price * (100 - $product_detail->discount_percent) / 100;
            
            $product = Product::find($product_detail->product_id);
            $result[$cart_detail_id]['name'] = $product->product_name;
            $result[$cart_detail_id]['image'] = $product->product_main_image;
        }

        // return address
        $customer_addresses = DB::table('customer_addresses')->where('customer_id', '=', $request->session()->get('CUSTOMER_ID'))
                                                    ->get();
        $result['customer_address_ids'] = $customer_addresses->map(function($customer_address){
            return $customer_address->id;
        });
        foreach($customer_addresses as $customer_address){
            $customer_address_id = $customer_address->id;
            $result[$customer_address_id]['address'] = $customer_address->specific_address . ', ' . $customer_address->ward_or_commune . ', ' . $customer_address->district . ', ' . $customer_address->city_or_province;
        }

        return view('consumer.checkout', ['customer_name' => $customer_name, 'result' => $result]);
    }

    public function check_order_detail_quantity(Request $request){
        $cart_detail_ids = json_decode($request->post('cart_detail_ids'));
        $product_detail_ids = json_decode($request->post('product_detail_ids'));
        $quantity_items = json_decode($request->post('quantity_items'));

        $item_count = count($cart_detail_ids);

        for ($index = 0; $index<$item_count; $index++){
            $product_detail_id = $product_detail_ids[$index];
            $product_detail = ProductDetail::find($product_detail_id);
            if ($quantity_items[$index] > $product_detail->quantity){
                $product_option = "";
                if ($product_detail->product_option_name_1 != ""){
                    $product_option .= $product_detail->product_option_value_1;
                }
                if ($product_detail->product_option_name_2 != ""){
                    $product_option .=  " - " . $product_detail->product_option_value_2;
                }
                if ($product_detail->product_option_name_3){
                    $product_option .= " - " . $product_detail->product_option_value_3;
                }
                $product = Product::find($product_detail->product_id);
                $check_order_detail_quantity_mess = "";
                if ($product_option != ""){
                    $check_order_detail_quantity_mess = "The quantity of " . $product->product_name . ' with "' . $product_option . '"';
                }
                else {
                    $check_order_detail_quantity_mess = "The quantity of " . $product->product_name;
                }
                $check_order_detail_quantity_mess .= " is not enough!!!";
                return response()->json(array('check_order_detail_quantity_mess' => $check_order_detail_quantity_mess));
            }
        }
        $check_order_detail_quantity_mess = "Order detail quantity is checked";
        return response()->json(array('check_order_detail_quantity_mess' => $check_order_detail_quantity_mess));
    }

    public function place_order(Request $request){
        $delivery_address = json_decode($request->post('delivery_address'));
        $payment_method = json_decode($request->post('payment_method'));
        $total = json_decode($request->post('total'));

        $customer_id = $request->session()->get('CUSTOMER_ID');
        $customer = Customer::find($customer_id);
        $order = new Order();
        $order->customer_id = $customer_id;
        $order->customer_phone = $customer->phone;
        $order->delivery_address = $delivery_address;
        $order->total = $total;
        $order->payment_method = $payment_method;
        $queryStatus = $order->save();

        if ($queryStatus > 0){
            $product_detail_ids = json_decode($request->post('product_detail_ids'));
            $quantity_items = json_decode($request->post('quantity_items'));
            $total_price_items = json_decode($request->post('total_price_items'));
            
            $item_count = count($product_detail_ids);
            DB::beginTransaction();
            for ($index = 0; $index < $item_count; $index++){
                $order_detail = new OrderDetail();
                $order_detail->order_id = $order->id;
                $order_detail->product_detail_id = intval($product_detail_ids[$index]);
                $order_detail->quantity = intval($quantity_items[$index]);
                $order_detail->total_price = floatval($total_price_items[$index]);
                $queryStatus1 = $order_detail->save();
                if ($queryStatus1 <= 0){
                    DB::rollBack();
                    break;
                }
            }
            DB::commit();
            // delete cart detail
            $cart_detail_ids = json_decode($request->post('cart_detail_ids'));
            for ($index = 0; $index < $item_count; $index++){
                $cart_detail = CartDetail::find(intval($cart_detail_ids[$index]));
                $cart_detail->delete();
            }
            $place_order_mess = "Place order successful";
        }
        else {
            $place_order_mess = "Can't create order!!!. Please refresh and try again.";
        }
        return response()->json(array('place_order_mess' => $place_order_mess));
    }

    public function my_order(Request $request, $type){
        $customer_name = $request->session()->get('CUSTOMER_NAME');
        $customer_id = $request->session()->get('CUSTOMER_ID');

        $orders = [];
        if ($type === "Incomplete") {
            $orders = DB::table('orders')->where('customer_id', '=', $customer_id)
                                    ->where('status', '!=', "Completed")
                                    ->where('status', '!=', "Cancelled")
                                    ->get();
        } else if ($type === "Completed") {
            $orders = DB::table('orders')->where('customer_id', '=', $customer_id)
                                    ->where('status', '=', $type)->get();
        } else if ($type === "Cancelled") {
            $orders = DB::table('orders')->where('customer_id', '=', $customer_id)
                                    ->where('status', '=', $type)->get();
        } else if ($type === "All") {
            $orders = DB::table('orders')->where('customer_id', '=', $customer_id)
                                    ->get();
        }
        $result['order_ids'] = $orders->map(function ($order){
            return $order->id;
        });

        foreach ($orders as $order){
            $order_id = $order->id;

            $result[$order_id]['customer_phone'] = $order->customer_phone;
            $result[$order_id]['delivery_address'] = $order->delivery_address;
            $result[$order_id]['total'] = $order->total;
            $result[$order_id]['payment_method'] = $order->payment_method;
            $result[$order_id]['payment_status'] = $order->payment_status;
            $result[$order_id]['status'] = $order->status;
            $result[$order_id]['created_at'] = $order->created_at;
            $result[$order_id]['updated_at'] = $order->updated_at;

            $order_details = DB::table('order_details')->where('order_id', '=', $order_id)->get();
            $result[$order_id]['order_detail_ids'] = $order_details->map(function ($order_detail){
                return $order_detail->id;
            });
            foreach ($order_details as $order_detail){
                $order_detail_id = $order_detail->id;
                
                $result[$order_id][$order_detail_id]['product_detail_id'] = $order_detail->product_detail_id;

                $product_detail = ProductDetail::find($order_detail->product_detail_id);
                $result[$order_id][$order_detail_id]['product_option_name_1'] = $product_detail->product_option_name_1;
                $result[$order_id][$order_detail_id]['product_option_value_1'] = $product_detail->product_option_value_1;
                $result[$order_id][$order_detail_id]['product_option_name_2'] = $product_detail->product_option_name_2;
                $result[$order_id][$order_detail_id]['product_option_value_2'] = $product_detail->product_option_value_2;
                $result[$order_id][$order_detail_id]['product_option_name_3'] = $product_detail->product_option_name_3;
                $result[$order_id][$order_detail_id]['product_option_value_3'] = $product_detail->product_option_value_3;

                $product = Product::find($product_detail->product_id);
                $result[$order_id][$order_detail_id]['name'] = $product->product_name;
                $result[$order_id][$order_detail_id]['image'] = $product->product_main_image;

                $result[$order_id][$order_detail_id]['quantity'] = $order_detail->quantity;
                $result[$order_id][$order_detail_id]['total_price'] = $order_detail->total_price;
            }
        }

        return view('consumer.my_order', ['customer_name' => $customer_name, 'result' => $result]);
    }

    public function cancel_order(Request $request, $order_id){
        $order = Order::find($order_id);
        if ($order->status != "Cancelled"){
            $order->status = "Cancelled";
            $order->payment_status = "Unpaid";
        }
        $queryStatus = $order->update();
        if ($queryStatus > 0) {
            $cancel_order_mess = "Cancel order successful.";
        } else {
            $cancel_order_mess = "Error!!! Cancel order failed.";
        }
        return response()->json(array('cancel_order_mess' => $cancel_order_mess));
    }

    public function category_page(Request $request, $category_slug, $page_index, $page_size){
        $customer_name = "";
        if ($request->session()->has('CUSTOMER_NAME')){
            $customer_name = $request->session()->get('CUSTOMER_NAME');
        }
        $result['category'] = DB::table('categories')->where('category_slug', '=', $category_slug)->first();
        $product_count = DB::table('products')->where('category_id', '=', $result['category']->id)->count();
        $product_skipped_count = 0;
        if ($page_index >= 1){
            $product_skipped_count = ($page_index - 1) * $page_size;
            if ($product_count - $product_skipped_count > $page_size) $product_taken_count = $page_size;
            else $product_taken_count = $product_count - $product_skipped_count;
        }
        $result['products'] = DB::table('products')->where('category_id', '=', $result['category']->id)
                                                    ->skip($product_skipped_count)->take($product_taken_count)->get();
        $result['product_ids'] = $result['products']->map(function($product){
            return $product->id;
        });
        foreach ($result['product_ids'] as $product_id){
            $result[$product_id]['product_detail'] = DB::table('product_details')->where('product_id', '=', $product_id)->first();
        }
        $result['page_index'] = $page_index;
        $result['page_count'] = ceil($product_count / $page_size);
        $result['page_size'] = $page_size;
        return view('consumer.category', ['customer_name'=>$customer_name, 'result'=>$result]);
    }

    public function search_result_page(Request $request, $keyword, $page_index, $page_size){
        $customer_name = "";
        if ($request->session()->has('CUSTOMER_NAME')){
            $customer_name = $request->session()->get('CUSTOMER_NAME');
        }
        $result['products'] = DB::table('products')->select('products.*')->join('categories', 'categories.id' , '=', 'products.category_id')
                                ->where('products.product_name', 'LIKE', '%'. $keyword . '%')
                                ->orWhere('categories.category_name', 'LIKE', '%' . $keyword . '%')->get();
        $product_count = count($result['products']);
        $product_skipped_count = 0;
        if ($page_index >= 1){
            $product_skipped_count = ($page_index - 1) * $page_size;
            if ($product_count - $product_skipped_count > $page_size) $product_taken_count = $page_size;
            else $product_taken_count = $product_count - $product_skipped_count;
        }
        $result['products'] = $result['products']->slice($product_skipped_count, $product_taken_count);
        $result['product_ids'] = $result['products']->map(function($product){
            return $product->id;
        });
        foreach ($result['product_ids'] as $product_id){
            $result[$product_id]['product_detail'] = DB::table('product_details')->where('product_id', '=', $product_id)->first();
        }
        $result['page_index'] = $page_index;
        $result['page_count'] = ceil($product_count / $page_size);
        $result['page_size'] = $page_size;
        $result['keyword'] = $keyword;
        // dd($result['products']);
        return view('consumer.search_result', ['customer_name'=>$customer_name, 'result'=>$result]);
    }
}
