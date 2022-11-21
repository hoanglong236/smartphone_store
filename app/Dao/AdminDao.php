<?php

namespace App\Dao;

use App\Dto\AdminDto;
use App\Dto\AdminLoggedInDto;
use Illuminate\Support\Facades\DB;

class AdminDao
{
  public function register($admin_dto)
  {
    $sql = 'INSERT INTO ' . ADMIN_TABLE . '(id, full_name, phone, account_id) VALUES(?, ?, ?, ?)';
    $params = [$admin_dto->id, $admin_dto->full_name, $admin_dto->phone, $admin_dto->account_id];

    $query_status = DB::insert($sql, $params);
    return $query_status > 0 ? true : false;
  }

  public function checkIdExist($id)
  {
    $sql = 'SELECT * FROM ' . ADMIN_TABLE . ' WHERE id = ?';
    $params = [$id];

    $result = DB::select($sql, $params);
    return count($result) > 0;
  }

  public function getAdminLoggedDtoByAccountId($account_id)
  {
    $sql = 'SELECT * FROM ' . ADMIN_TABLE . ' WHERE account_id = ?';
    $params = [$account_id];

    // account_id is unique
    $result = DB::select($sql, $params);

    if (empty($result)) {
      return false;
    }

    $admin_dto = new AdminLoggedInDto();
    $admin_dto->id = $result[0]->id;
    $admin_dto->full_name = $result[0]->full_name;

    return $admin_dto;
  }
}
