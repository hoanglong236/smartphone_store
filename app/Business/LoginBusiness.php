<?php

namespace App\Business;

use App\Dao\AccountDao;
use App\Dao\AdminDao;

class LoginBusiness
{
  private $account_dao;
  private $admin_dao;

  public function __construct()
  {
    $this->account_dao = new AccountDao();
    $this->admin_dao = new AdminDao();
  }

  public function getAccount($email)
  {
    return $this->account_dao->getAccountDto($email);
  }

  public function getAdminLoggedIn($account_id) {
    return $this->admin_dao->getAdminLoggedDtoByAccountId($account_id);
  }
}
