<?php

namespace App\Dao;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AccountDao
{
    public function getAccount($email)
    {
        $sql = 'SELECT * FROM ' . ACCOUNT_TABLE . ' WHERE email = ?';
        $params = [$email];

        $result = DB::select($sql, $params);

        if (empty($result)) {
            return false;
        }

        // email is unique
        return $result[0];
    }

    public function register($account_obj)
    {
        $sql = 'INSERT INTO ' . ACCOUNT_TABLE . '(id, email, password) VALUES(?, ?, ?)';
        $params = [$account_obj->id, $account_obj->email, Hash::make($account_obj->password)];

        $query_status = DB::insert($sql, $params);
        return $query_status > 0 ? true : false;
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
