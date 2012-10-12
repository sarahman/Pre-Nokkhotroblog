<?php

/**
 * User Abstract Model
 * @userprofile    Model
 * @package     User
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://rightbrainsolution.com)
 */
class Blog_Model_UserProfile extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_UserProfile
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new User_Model_Dao_UserProfile();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function save($data = array())
    {
        if (empty($data)) {
            return false;
        }
        $authNamespace   = new Zend_Session_Namespace('userInformation');
        $data['user_id'] = $authNamespace->userData['user_id'];
        $userId          = $this->dao->create($data);
        return $userId;
    }

    public function modify($data = array())
    {
        if (empty($data)) {
            return false;
        }
        $data['update_date'] = date('Y-m-d H:i:s');
        $authNamespace       = new Zend_Session_Namespace('userInformation');
        $data['update_by']   = $authNamespace->userData['user_id'];
        $this->dao->modify($data, $data['user_id']);
        return true;
    }
}
