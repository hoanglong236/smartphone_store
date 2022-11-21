<?php

namespace App\Dao;

use Illuminate\Support\Facades\DB;

class AdminDao
{
    public function register($admin_obj)
    {
        $sql = 'INSERT INTO ' . ADMIN_TABLE . '(id, full_name, phone, account_id) VALUES(?, ?, ?, ?)';
        $params = [$admin_obj->id, $admin_obj->full_name, $admin_obj->phone, $admin_obj->account_id];

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
}
