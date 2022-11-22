<?php

namespace App\Http\Controllers\Admin;

use App\Business\LoginBusiness;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    $account = $business->getAccountByEmail($email);

    if ($account === false) {
      $request->session()->flash('error_mess', 'Please enter valid login details');
      return redirect()->route(ADMIN_LOGIN_URL);
    }

    if (Hash::check($password, $account->password)) {
      $admin_logged_in = $business->getAdminLoggedIn($account->id);
      $request->session()->put('ADMIN_LOGGED_IN', $admin_logged_in);
      return redirect()->route('admin.dashboard');
    }

    $request->session()->flash('error_mess', 'Please enter correct password');
    return redirect()->route(ADMIN_LOGIN_URL);
  }

  public function logout(Request $request)
  {
    $request->session()->forget('ADMIN_LOGGED_IN');
    $request->session()->flash('success_mess', 'Logout successfully');
    return redirect()->route(ADMIN_LOGIN_URL);
  }
}
