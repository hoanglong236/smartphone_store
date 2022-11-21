<?php

namespace App\Dao;

use App\Dto\AccountDto;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AccountDao
{
  public function getAccountDto($email)
  {
    $sql = 'SELECT * FROM ' . ACCOUNT_TABLE . ' WHERE email = ?';
    $params = [$email];

    $result = DB::select($sql, $params);
    if (empty($result)) {
      return false;
    }

    $account_dto = new AccountDto();
    $account_dto->id = $result[0]->id;
    $account_dto->email = $result[0]->email;
    $account_dto->password = $result[0]->password;

    return $account_dto;
  }

  public function register($account_dto)
  {
    $sql = 'INSERT INTO ' . ACCOUNT_TABLE . '(id, email, password) VALUES(?, ?, ?)';
    $params = [$account_dto->id, $account_dto->email, Hash::make($account_dto->password)];

    $query_status = DB::insert($sql, $params);
    return $query_status > 0;
  }

  public function checkIdExist($id)
  {
    $sql = 'SELECT * FROM ' . ACCOUNT_TABLE . ' WHERE id = ?';
    $params = [$id];

    $result = DB::select($sql, $params);
    return count($result) > 0;
  }

  public function checkEmailExist($email)
  {
    $sql = 'SELECT * FROM ' . ACCOUNT_TABLE . ' WHERE email = ?';
    $params = [$email];

    $result = DB::select($sql, $params);
    return count($result) > 0;
  }
}
