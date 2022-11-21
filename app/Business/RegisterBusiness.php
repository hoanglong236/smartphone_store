<?php

namespace App\Business;

use App\Dao\AccountDao;
use App\Dao\AdminDao;
use App\Dto\AccountDto;
use App\Dto\AdminDto;

class RegisterBusiness
{
  private $account_dao;
  private $admin_dao;

  public function __construct()
  {
    $this->account_dao = new AccountDao();
    $this->admin_dao = new AdminDao();
  }

  public function register($register_obj)
  {
    $account_dto = new AccountDto();
    $account_dto->id = $this->generateAccountId();
    $account_dto->email = $register_obj->email;
    $account_dto->password = $register_obj->password;

    $query_status = $this->account_dao->register($account_dto);

    if (!$query_status) {
      return $query_status;
    }

    $admin_dto = new AdminDto();
    $admin_dto->id = $this->generateAdminId();
    $admin_dto->full_name = $register_obj->full_name;
    $admin_dto->phone = $register_obj->phone;
    $admin_dto->account_id = $account_dto->id;

    $query_status = $this->admin_dao->register($admin_dto);

    return $query_status;
  }

  public function checkEmailExist($email)
  {
    return $this->account_dao->checkEmailExist($email);
  }

  private function generateAccountId()
  {
    $id = '';
    do {
      $id = substr(uniqid(mt_rand(), true), 0, 10);
    } while ($this->account_dao->checkIdExist($id));

    return $id;
  }

  private function generateAdminId()
  {
    $id = '';
    do {
      $id = substr(uniqid(mt_rand(), true), 0, 10);
    } while ($this->admin_dao->checkIdExist($id));

    return $id;
  }
}
