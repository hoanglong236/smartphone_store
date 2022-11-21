<?php

namespace App\Http\Controllers\Admin;

use App\Business\LoginBusiness;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
  public function index()
  {
    return view('admin.auth_pages.login');
  }

  public function login_handler(Request $request)
  {
    $email = $request->post('email');
    $password = $request->post('password');

    $business = new LoginBusiness();
    $account = $business->getAccount($email);

    if ($account === false) {
      $request->session()->flash('error_mess', 'Please enter valid login details');
      return redirect()->route(ADMIN_LOGIN_URL);
    }

    if (Hash::check($password, $account->password)) {
      $request->session()->put('ADMIN_LOGIN', true);
      $request->session()->put('ADMIN_ID', $account->id);
      $request->session()->put('ADMIN_NAME', $account->fullname);
      return redirect()->route('admin.dashboard');
    }

    $request->session()->flash('error_mess', 'Please enter correct password');
    return redirect()->route(ADMIN_LOGIN_URL);
  }

  public function dashboard(Request $request)
  {
    $admin_name = $request->session()->get('ADMIN_NAME');
    return view('admin.dashboard', ['admin_name' => $admin_name]);
  }

  public function logout(Request $request)
  {
    $request->session()->forget('ADMIN_LOGIN');
    $request->session()->forget('ADMIN_ID');
    $request->session()->forget('ADMIN_NAME');
    $request->session()->flash('success_mess', 'Logout successfully');
    return redirect()->route(ADMIN_LOGIN_URL);
  }
}
