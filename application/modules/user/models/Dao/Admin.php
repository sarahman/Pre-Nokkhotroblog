<?php

/**
 * Admin Dao
 * @category    Dao
 * @package     User
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://rightbrainsolution.com)
 */
class User_Model_Dao_Admin extends User_Model_Dao_UserAbstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('admins', 'user_id');
    }
}