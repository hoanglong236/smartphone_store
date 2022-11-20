<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {

    public function index() {
        return view('admin.login');
    }

    public function auth(Request $request) {
        $email = $request->post('email');
        $password = $request->post('password');

        $result = Admin::where(['email'=>$email])->first();
        if(isset($result->id)){
            if (Hash::check($password, $result->password)){
                $request->session()->put('ADMIN_LOGIN', true);
                $request->session()->put('ADMIN_ID', $result->id);
                $request->session()->put('ADMIN_NAME', $result->fullname);
                return redirect()->route('admin.dashboard');
            }
            else{
                $request->session()->flash('error_mess', 'Please enter correct password');
                return redirect()->route('admin');
            }
        }
        else{
            $request->session()->flash('error_mess', 'Please enter valid login details');
            return redirect()->route('admin');
        }
    }

    public function dashboard(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        return view('admin.dashboard', ['admin_name'=>$admin_name]);
    }

    public function logout(Request $request) {
        $request->session()->forget('ADMIN_LOGIN');
        $request->session()->forget('ADMIN_ID');
        $request->session()->forget('ADMIN_NAME');
        $request->session()->flash('success_mess', 'Logout successfully');
        return redirect()->route('admin');
    }

    public function register() {
        $user_roles = array('Admin', 'Cashier');
        return view('admin.register',['user_roles'=>$user_roles]);
    }

    public function register_handle(Request $request) {
        $email = $request->post('email');
        $password = $request->post('password');
        $retype_password = $request->post('retype_password');
        $fullname = $request->post('fullname');
        $phone = $request->post('phone');
        $role = $request->post('select_role');

        if ($password != $retype_password){
            $request->session()->flash('error_mess', 'Please retype correct password');
            return redirect()->route('admin.register');
        }

        $password = Hash::make($password);
        $queryStatus = DB::insert("insert into admins(email, password, fullname, phone, role) values (?, ?, ?, ?, ?)", array($email, $password, $fullname, $phone, $role));

        if ($queryStatus > 0) $request->session()->flash('success_mess', 'Register successfully');
        else $request->session()->flash('error_mess', 'Register failed!!!');
        return redirect()->route('admin');
    }
}
