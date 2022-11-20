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

    public function get_account($email)
    {
        return $this->account_dao->get_account($email);
    }
}
