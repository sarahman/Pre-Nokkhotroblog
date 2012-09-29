<?php

/**
 * User Abstract Dao
 *
 * @category    Dao
 * @package     User
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://rightbrainsolution.com)
 */
abstract class User_Model_Dao_UserAbstract extends Speed_Model_Dao_Abstract
{
    public function save($data)
    {
        return $this->create($data);
    }
}