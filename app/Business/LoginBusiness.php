<?php

namespace App\Business;

use App\Dao\AccountDao;

class LoginBusiness
{
  private $account_dao;

  public function __construct()
  {
    $this->account_dao = new AccountDao();
  }

  public function getAccount($email)
  {
    return $this->account_dao->getAccount($email);
  }
}
