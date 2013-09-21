<?php
/**
 * Blog category Model
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_AdminUser extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_AdminUser
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_AdminUser();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getDetailForAdmin($userId)
    {
        if (empty ($userId)) {
            return false;
        }
        $record = $this->dao->getDetailForAdmin($userId);
        return $record;
    }

    public function save($data = array())
    {
        if (empty($data)) {
            return false;
        }
        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $authToken     = $this->applyHashing($data['email_address'], $this->salt);
        (empty($data['password'])) || ($data['password'] = $this->applyHashing($data['password'], $this->salt));
        $data['activation_code'] = $this->applyHashing($data['username'], $this->salt);
        $data['auth_token']      = $authToken;
        $data['user_status']     = User_Model_UserStatus::INACTIVE;
        $data['create_date']     = date('Y-m-d H:i:s');
        $data['create_by']       = $authNamespace->adminData['admin_id'];
        return $this->dao->create($data);
    }

    protected function applyHashing($string, $salt)
    {
        return sha1($string . $salt);
    }

    public function validateUser($data = array())
    {
        if (empty($data)) {
            return false;
        }
        (empty($data['password'])) || ($data['password'] = $this->applyHashing($data['password'], $this->salt));
        return $this->dao->validateUser($data);
    }

    public function modify($data = array(), $postId = null)
    {
        if (empty($data) || empty($postId)) {
            return false;
        }
        $authNamespace = new Zend_Session_Namespace('adminInformation');
        (empty($data['password'])) || ($data['password'] = $this->applyHashing($data['password'], $this->salt));
        $data['update_date'] = date('Y-m-d H:i:s');
        $data['update_by']   = $authNamespace->adminData['admin_id'];
        $this->dao->modify($data, $postId);
        return true;
    }

    public function setSelectStatus($data, $userId)
    {
        if (empty($data) AND (empty($userId))) {
            return false;
        }
        $data['update_date'] = date('Y-m-d H:i:s');
        $status              = $this->getSelectStatus($userId);
        if ($status['user_status'] == 'active') {
            $data['user_status'] = 'in-active';
        } else {
            $data['user_status'] = 'active';
        }
        $this->dao->modify($data, $userId);
        return true;
    }

    public function getSelectStatus($userId)
    {
        if (empty($userId)) {
            return false;
        }
        return $this->dao->getSelectStatus($userId);
    }
}

