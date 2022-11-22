<?php

namespace App\Http\Controllers\Admin;

use App\Business\RegisterBusiness;
use App\Dto\RegisterDto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
  public function index()
  {
    return view('admin.auth_pages.register');
  }

  // TODO: handle retype in javascript
  public function register_handler(Request $request)
  {
    $register_dto = new RegisterDto();
    $register_dto->email = $request->post('email');
    $register_dto->password = $request->post('password');
    $register_dto->full_name = $request->post('fullname');
    $register_dto->phone = $request->post('phone');

    $business = new RegisterBusiness();

    if ($business->checkEmailExist($register_dto->email)) {
      $request->session()->flash('error_mess', 'Email is existed');
      return redirect()->route(ADMIN_REGISTER_ROUTE);
    }

    $status = $business->register($register_dto);

    if (!$status) {
      $request->session()->flash('error_mess', 'Register failed!!!');
      return redirect()->route(ADMIN_REGISTER_ROUTE);
    }

    $request->session()->flash('success_mess', 'Register successfully');
    return redirect()->route(ADMIN_LOGIN_ROUTE);
  }
}
