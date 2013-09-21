<?php

/**
 * User Status Model
 * @category    Model
 * @package     User
 * @author      Eftakhairul Islam <eftakhairul@gmail.com>
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class User_Model_UserStatus
{
    const ACTIVE   = 'active';
    const BANNED   = 'banned';
    const INACTIVE = 'in-active';

    public function getAll()
    {
        return array(
            self::ACTIVE => ucfirst(self::ACTIVE),
            self::INACTIVE => ucfirst(self::INACTIVE),
            self::BANNED => ucfirst(self::BANNED)
        );
    }
}
