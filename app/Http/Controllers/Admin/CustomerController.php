<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $result['data'] = Customer::all();
        return view('admin.customer', ['admin_name'=>$admin_name, 'table_data'=>$result['data']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_customer(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        return view('admin.add_category', ['admin_name'=>$admin_name]);
    }

    public function add_customer_handle(Request $request){

        $request->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'phone'=>'required|unique:customer',
            'email'=>'required|unique:customer',
            'password'=>'required',
        ]);

        $customer = new Customer();

        $customer->firstname = $request->post('firstname');
        $customer->lastname = $request->post('lastname');
        $customer->gender = $request->post('gender');
        $customer->phone = $request->post('phone');
        $customer->email = $request->post('email');
        $customer->password = $request->post('password');
        $customer->status = $request->post('status');

        $queryStatus = $customer->save();
        if ($queryStatus > 0)
            $customer_message = "Customer inserted.";
        else $customer_message = "Error! Insert failed.";

        $request->session()->flash('alert', $customer_message);
        return redirect()->route('admin.customer');
    }

    public function delete_customer(Request $request, $customer_id)
    {
        $customer = Customer::find($customer_id);

        $queryStatus = $customer->delete();
        if ($queryStatus > 0)
            $customer_message = "Customer deleted.";
        else $customer_message = "Error! Delete failed.";
        
        $request->session()->flash('alert', $customer_message);
        return redirect()->route('admin.customer');
    }

    public function change_status(Request $request, $customer_id){
        $customer = Customer::find($customer_id);

        if ($customer->status == 'Enable') $customer->status = 'Disable';
        else $customer->status = 'Enable';

        $queryStatus = $customer->update();
        if ($queryStatus > 0)
            $customer_message = "Customer Status updated.";
        else $customer_message = "Error! Update failed.";
        
        $request->session()->flash('alert', $customer_message);
        return redirect()->route('admin.customer');
    }

    public function customer_detail(Request $request, $customer_id){
        $admin_name = $request->session()->get('ADMIN_NAME');
        $customer = Customer::find($customer_id);
        $customer_addresses = DB::table('customer_addresses')->where('customer_id', '=', $customer_id)->get();
        return view('admin.customer_detail', ['admin_name'=>$admin_name, 'customer'=>$customer, 'customer_addresses'=>$customer_addresses]);
    }

    // public function update_category(Request $request, $category_id)
    // {
    //     $admin_name = $request->session()->get('ADMIN_NAME');
    //     $category = Category::find($category_id);
    //     return view('admin.update_category', ['admin_name'=>$admin_name, 'category'=>$category]);
    // }

    // public function update_category_handle(Request $request){

    //     $category_id = $request->post('id');

    //     $request->validate([
    //         'category_name'=>'required|unique:categories,category_name,'.$category_id,
    //         'category_slug'=>'required|unique:categories,category_slug,'.$category_id,
    //     ]);

        
    //     $category = Category::where(['id'=>$category_id])->first();
    //     $old_category = Category::where(['id'=>$category_id])->first();

    //     $category->category_name = $request->post('category_name');
    //     $category->category_slug = $request->post('category_slug');

    //     if ($old_category == $category){
    //         $category_message = "Nothing has changed!!!";
    //     }
    //     else {
    //         $queryStatus = $category->update();
    //         if ($queryStatus > 0)
    //             $category_message = "Category updated.";
    //         else $category_message = "Error! Update failed.";
    //     }

    //     $request->session()->flash('alert', $category_message);
    //     return redirect()->route('admin.category');
    // }
}
