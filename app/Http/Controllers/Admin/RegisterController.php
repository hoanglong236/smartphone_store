<?php
namespace App\Http\Controllers\Admin;

require_once('../constant/Constant.php');

use App\Business\AdminAccountBusiness;
use App\Dto\AdminAccountDto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller {

    public function index() {
        return view('admin.register');
    }

    public function register_handler(Request $request) {
        $account_dto = new AdminAccountDto();
        $account_dto->email = $request->post('email');
        $account_dto->password = $request->post('password');
        $account_dto->fullname = $request->post('fullname');
        $account_dto->phone = $request->post('phone');

        $retype_password = $request->post('retype_password');

        if ($account_dto->password !== $retype_password){
            $request->session()->flash('error_mess', 'Please retype correct password');
            return redirect()->route(ADMIN_REGISTER_URL);
        }

        $business = new AdminAccountBusiness();
        $status = $business->register($account_dto);

        if ($status) {
            $request->session()->flash('success_mess', 'Register successfully');
            return redirect()->route(ADMIN_LOGIN_URL);
        }

        $request->session()->flash('error_mess', 'Register failed!!!');
        return redirect()->route(ADMIN_REGISTER_URL);
    }
}
