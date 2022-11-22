<?php

namespace App\Dao;

use App\Vo\AdminLoggedInVo;
use App\Vo\AccountVo;
use Illuminate\Support\Facades\DB;

class LoginDao
{
  public function getAccountByEmail($email)
  {
    $sql = 'SELECT * FROM ' . ACCOUNT_TABLE . ' WHERE email = ?';
    $params = [$email];

    $result = DB::select($sql, $params);
    if (empty($result)) {
      return false;
    }

    $account = new AccountVo();
    $account->id = $result[0]->id;
    $account->email = $result[0]->email;
    $account->password = $result[0]->password;

    return $account;
  }

  public function getAdminLoggedInByAccountId($account_id)
  {
    $sql = 'SELECT * FROM ' . ADMIN_TABLE . ' WHERE account_id = ?';
    $params = [$account_id];

    // account_id is unique
    $result = DB::select($sql, $params);

    if (empty($result)) {
      return false;
    }

    $admin_logged_in = new AdminLoggedInVo();
    $admin_logged_in->id = $result[0]->id;
    $admin_logged_in->full_name = $result[0]->full_name;

    return $admin_logged_in;
  }
}
