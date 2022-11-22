<?php

namespace App\Business;

use App\Dao\LoginDao;

class LoginBusiness
{
  private $login_dao;

  public function __construct()
  {
    $this->login_dao = new LoginDao();
  }

  public function getAccountByEmail($email)
  {
    return $this->login_dao->getAccountByEmail($email);
  }

  public function getAdminLoggedIn($account_id) {
    return $this->login_dao->getAdminLoggedInByAccountId($account_id);
  }
}
