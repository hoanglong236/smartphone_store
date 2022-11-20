<?php
namespace App\Business;

use App\Dto\AdminAccountDto;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminAccountBusiness
{

    public function get_account($email)
    {
        $sql = "SELECT * FROM admin_account WHERE email = ?";
        $params = [$email];

        $result = DB::select($sql, $params);

        if (empty($result)) {
            return false;
        }

        // email is unique
        return $result[0];
    }

    public function register(AdminAccountDto $admin_account_dto)
    {
        $account_id = $this->generate_account_id();

        $sql = "INSERT INTO admin_account(id, email, password, fullname, phone) VALUES(?, ?, ?, ?, ?)";
        $params = [
            $account_id,
            $admin_account_dto->email,
            Hash::make($admin_account_dto->password),
            $admin_account_dto->fullname,
            $admin_account_dto->phone
        ];

        $query_status = DB::insert($sql, $params);
        return $query_status > 0 ? true : false;
    }

    private function check_accout_id($account_id)
    {
        $sql = "SELECT * FROM admin_account WHERE id = ?";
        $params = [$account_id];

        $result = DB::select($sql, $params);

        return (count($result) > 0);
    }

    private function generate_account_id()
    {
        $id = '';
        do {
            $id = substr(uniqid(mt_rand(), true), 0, 10);
        } while ($this->check_accout_id($id));
        return $id;
    }
}
