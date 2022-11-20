<?php
namespace App\Business;

use App\Dao\AccountDao;
use App\Dao\AdminDao;
use stdClass;

class RegisterBusiness
{
    private $account_dao;
    private $admin_dao;

    public function __construct() {
        $this->account_dao = new AccountDao();
        $this->admin_dao = new AdminDao();
    }


    public function register($register_dto)
    {
        $account_obj = new stdClass;
        $account_obj->id = $this->generate_account_id();
        $account_obj->email = $register_dto->email;
        $account_obj->password = $register_dto->password;

        $query_status = $this->account_dao->register($account_obj);

        if (!$query_status) {
            return $query_status;
        }

        $admin_obj = new stdClass;
        $admin_obj->id =$this->generate_admin_id();
        $admin_obj->full_name = $register_dto->full_name;
        $admin_obj->phone = $register_dto->phone;
        $admin_obj->account_id = $account_obj->id;

        $query_status = $this->admin_dao->register($admin_obj);

        return $query_status;
    }

    private function generate_account_id()
    {
        $id = '';
        do {
            $id = substr(uniqid(mt_rand(), true), 0, 10);
        } while ($this->account_dao->check_id_exist($id));

        return $id;
    }

    private function generate_admin_id() {
        $id = '';
        do {
            $id = substr(uniqid(mt_rand(), true), 0, 10);
        } while ($this->admin_dao->check_id_exist($id));

        return $id;
    }
}
