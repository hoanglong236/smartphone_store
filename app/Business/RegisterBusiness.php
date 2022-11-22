<?php

namespace App\Business;

use App\Dao\RegisterDao;
use App\Vo\AccountVo;
use App\Vo\AdminVo;

class RegisterBusiness
{
  private $register_dao;

  public function __construct()
  {
    $this->register_dao = new RegisterDao();
  }

  public function register($register_dto)
  {
    $account_vo = new AccountVo();
    $account_vo->id = $this->generateAccountId();
    $account_vo->email = $register_dto->email;
    $account_vo->password = $register_dto->password;

    $query_status = $this->register_dao->registerAccount($account_vo);

    if (!$query_status) {
      return $query_status;
    }

    $admin_vo = new AdminVo();
    $admin_vo->id = $this->generateAdminId();
    $admin_vo->full_name = $register_dto->full_name;
    $admin_vo->phone = $register_dto->phone;
    $admin_vo->account_id = $account_vo->id;

    $query_status = $this->register_dao->registerAdmin($admin_vo);

    return $query_status;
  }

  public function checkEmailExist($email)
  {
    return $this->register_dao->isAccountEmailExist($email);
  }

  private function generateAccountId()
  {
    $account_id = '';
    do {
      $account_id = substr(uniqid(mt_rand(), true), 0, 10);
    } while ($this->register_dao->isAccountIdExist($account_id));

    return $account_id;
  }

  private function generateAdminId()
  {
    $admin_id = '';
    do {
      $admin_id = substr(uniqid(mt_rand(), true), 0, 10);
    } while ($this->register_dao->isAdminIdExist($admin_id));

    return $admin_id;
  }
}
