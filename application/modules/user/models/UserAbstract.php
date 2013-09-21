<?php

/**
 * User Abstract Model
 * @category    Model
 * @package     User
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://rightbrainsolution.com)
 */
abstract class User_Model_UserAbstract extends Speed_Model_Abstract
{
    /**
     * @var User_Model_Dao_UserAbstract
     */
    protected $dao;

    public function save(array $data)
    {
        return $this->dao->create($data);
    }

    public function modify(array $data, $userId)
    {
        return $this->dao->modify($data, $userId);
    }
}