<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $result['data'] = Coupon::all();
        return view('admin.coupon', ['admin_name'=>$admin_name, 'table_data'=>$result['data']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_coupon(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        return view('admin.add_coupon', ['admin_name'=>$admin_name]);
    }

    public function add_coupon_handle(Request $request){

        $request->validate([
            'coupon_title'=>'required|unique:coupons',
            'coupon_code'=>'required|unique:coupons',
        ]);

        $coupon = new Coupon();

        $coupon->coupon_title = $request->post('coupon_title');
        $coupon->coupon_code = $request->post('coupon_code');
        $coupon->coupon_type = $request->post('coupon_type');
        if ($coupon->coupon_type == "Percent")
            $coupon->coupon_percent_value = $request->post('coupon_percent_value');
        else
            $coupon->coupon_dollar_value = $request->post('coupon_dollar_value');
        $coupon->coupon_quantity = $request->post('coupon_quantity');
        $coupon->coupon_start_date = $request->post('coupon_start_date');
        $coupon->coupon_finish_date = $request->post('coupon_finish_date');
        $coupon->coupon_status = $request->post('coupon_status');
        
        $queryStatus = $coupon->save();
        if ($queryStatus > 0)
            $coupon_message = "Coupon inserted.";
        else $coupon_message = "Error! Insert failed.";

        $request->session()->flash('alert', $coupon_message);
        return redirect()->route('admin.coupon');
    }

    public function delete_coupon(Request $request, $coupon_id) 
    {
        $coupon = Coupon::find($coupon_id);

        $queryStatus = $coupon->delete();
        if ($queryStatus > 0)
            $coupon_message = "Coupon deleted.";
        else $coupon_message = "Error! Delete failed.";

        $request->session()->flash('alert', $coupon_message);
        return redirect()->route('admin.coupon');
    }

    public function update_coupon(Request $request, $coupon_id)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $coupon = Coupon::find($coupon_id);
        return view('admin.update_coupon', ['admin_name'=>$admin_name, 'coupon'=>$coupon]);
    }

    public function update_coupon_handle(Request $request){

        $coupon_id = $request->post('id');

        $request->validate([
            'coupon_title'=>'required|unique:coupons,coupon_title,'.$coupon_id,
            'coupon_code'=>'required|unique:coupons,coupon_code,'.$coupon_id,
        ]);

        
        $coupon = Coupon::where(['id'=>$coupon_id])->first();
        $old_coupon = Coupon::where(['id'=>$coupon_id])->first();

        $coupon->coupon_title = $request->post('coupon_title');
        $coupon->coupon_code = $request->post('coupon_code');
        $coupon->coupon_type = $request->post('coupon_type');
        if ($coupon->coupon_type == "Percent"){
            $coupon->coupon_percent_value = $request->post('coupon_percent_value');
            $coupon->coupon_dollar_value = 0;
        }
        else{
            $coupon->coupon_percent_value = 0;
            $coupon->coupon_dollar_value = $request->post('coupon_dollar_value');
        }
        $coupon->coupon_quantity = $request->post('coupon_quantity');
        $coupon->coupon_start_date = $request->post('coupon_start_date');
        $coupon->coupon_finish_date = $request->post('coupon_finish_date');
        $coupon->coupon_status = $request->post('coupon_status');

        // compare value of two object
        if ($coupon == $old_coupon){
            $coupon_message = "Nothing has changed!!!";
        }
        else {
            $queryStatus = $coupon->update();
            if ($queryStatus > 0)
                $coupon_message = "Coupon updated.";
            else $coupon_message = "Error! Update failed.";
        }
        
        $request->session()->flash('alert', $coupon_message);
        return redirect()->route('admin.coupon');
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Coupon  $coupon
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Coupon $coupon)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Coupon  $coupon
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Coupon $coupon)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Coupon  $coupon
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Coupon $coupon)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Coupon  $coupon
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Coupon $coupon)
    // {
    //     //
    // }
}
