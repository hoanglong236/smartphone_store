<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\ProductDetail;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $orders = Order::all();
        return view('admin.order', ['admin_name' => $admin_name, 'orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_order_status(Request $request, $order_id, $status)
    {
        $order = Order::find($order_id);
        $order->status = $status;
        if ($order->status == "Completed") $order->payment_status = "Paid";
        $queryStatus = $order->update();
        if ($queryStatus > 0) {
            $order_mess = "Update Order status successfully.";
        } else {
            $order_mess = "Error!!! Update failed.";
        }
        return response()->json(array('order_mess' => $order_mess));
    }

    public function delete_order(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $queryStatus = $order->delete();
        if ($queryStatus > 0) {
            $order_mess = "Delete Order successfully.";
        } else {
            $order_mess = "Error!!! Delete failed.";
        }
        return response()->json(array('order_mess' => $order_mess));
    }

    public function order_detail(Request $request, $order_id)
    {
        $order_details = DB::table('order_details')->where('order_id', '=', $order_id)->get();
        $result['order_detail_ids'] = $order_details->map(function($order_detail){
            return $order_detail->id;
        });

        foreach ($order_details as $order_detail) {
            $result[$order_detail->id]['quantity'] = $order_detail->quantity;
            $result[$order_detail->id]['total_price'] = $order_detail->total_price; 

            $product_detail = ProductDetail::find($order_detail->product_detail_id);
            $product_option = "";
            if ($product_detail->product_option_name_1 != "") {
                $product_option .= $product_detail->product_option_value_1;
            }
            if ($product_detail->product_option_name_2 != "") {
                $product_option .= " - " . $product_detail->product_option_value_2;
            }
            if ($product_detail->product_option_name_3) {
                $product_option .= " - " . $product_detail->product_option_value_3;
            }
            $result[$order_detail->id]['option_name'] = $product_option;
            $product = Product::find($product_detail->product_id);
            $result[$order_detail->id]['name'] = $product->product_name;
            $result[$order_detail->id]['image'] = $product->product_main_image;
        }
        $admin_name = $request->session()->get('ADMIN_NAME');
        $order = Order::find($order_id);
        $customer = Customer::find($order->customer_id);
        return view('admin.order_detail', ['admin_name' => $admin_name, 'order' => $order, 'customer' => $customer, 'result' => $result]);
    }
}
