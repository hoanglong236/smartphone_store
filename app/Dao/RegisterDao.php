<?php

namespace App\Dao;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterDao
{
  public function registerAdmin($admin)
  {
    $sql = 'INSERT INTO ' . ADMIN_TABLE . '(id, full_name, phone, account_id) VALUES(?, ?, ?, ?)';
    $params = [$admin->id, $admin->full_name, $admin->phone, $admin->account_id];

    $query_status = DB::insert($sql, $params);
    return $query_status > 0 ? true : false;
  }

  public function isAdminIdExist($id)
  {
    $sql = 'SELECT * FROM ' . ADMIN_TABLE . ' WHERE id = ?';
    $params = [$id];

    $result = DB::select($sql, $params);
    return count($result) > 0;
  }

  public function registerAccount($account)
  {
    $sql = 'INSERT INTO ' . ACCOUNT_TABLE . '(id, email, password) VALUES(?, ?, ?)';
    $params = [$account->id, $account->email, Hash::make($account->password)];

    $query_status = DB::insert($sql, $params);
    return $query_status > 0;
  }

  public function isAccountIdExist($account_id)
  {
    $sql = 'SELECT * FROM ' . ACCOUNT_TABLE . ' WHERE id = ?';
    $params = [$account_id];

    $result = DB::select($sql, $params);
    return count($result) > 0;
  }

  public function isAccountEmailExist($email)
  {
    $sql = 'SELECT * FROM ' . ACCOUNT_TABLE . ' WHERE email = ?';
    $params = [$email];

    $result = DB::select($sql, $params);
    return count($result) > 0;
  }
}
