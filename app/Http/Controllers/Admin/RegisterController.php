<?php
namespace App\Http\Controllers\Admin;

use App\Business\RegisterBusiness;
use App\Dto\RegisterDto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller {

    public function index() {
        return view('admin.register');
    }

    public function register_handler(Request $request) {
        $register_dto = new RegisterDto();
        $register_dto->email = $request->post('email');
        $register_dto->password = $request->post('password');
        $register_dto->full_name = $request->post('fullname');
        $register_dto->phone = $request->post('phone');

        $retype_password = $request->post('retype_password');

        if ($register_dto->password !== $retype_password){
            $request->session()->flash('error_mess', 'Please retype correct password');
            return redirect()->route(ADMIN_REGISTER_URL);
        }

        $business = new RegisterBusiness();
        $status = $business->register($register_dto);

        if ($status) {
            $request->session()->flash('success_mess', 'Register successfully');
            return redirect()->route(ADMIN_LOGIN_URL);
        }

        $request->session()->flash('error_mess', 'Register failed!!!');
        return redirect()->route(ADMIN_REGISTER_URL);
    }
}
