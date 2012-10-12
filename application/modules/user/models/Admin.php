<?php

/**
 * Admin Model
 * @category    Model
 * @package     User
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://rightbrainsolution.com)
 */
class User_Model_Admin extends User_Model_UserAbstract
{
    /**
     * @var User_Model_Dao_Admin
     */
    protected $dao;

    public function __construct(User_Model_Dao_UserAbstract $dao = null)
    {
        if (empty($dao)) {
            $this->setDao(new User_Model_Dao_Admin());
        } else {
            $this->setDao($dao);
        }
    }
}