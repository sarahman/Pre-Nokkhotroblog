<?php
/**
 * users Model
 * @users Model
 * @package admin
 * @author Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright Copyright (c) 2011
 */
class Admin_Model_Role extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_Role
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_Role();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getDetailForAdmin($role_id)
    {
        if (empty ($role_id)) {
            return false;
        }
        $record = $this->dao->getDetailForAdmin($role_id);
        return $record;
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $categoryId = $this->dao->create($data);
        return $categoryId;
    }

    public function setPublishStatus($data, $role_id)
    {
        if (empty($data) AND (empty($role_id))) {
            return false;
        }
        $status = $this->getPublishStatus($role_id);
        if ($status['user_status'] == 'active') {
            $data['user_status'] = 'in-active';
        } else {
            $data['user_status'] = 'active';
        }
        $this->dao->modify($data, $role_id);
        return true;
    }

    public function getPublishStatus($role_id)
    {
        if (empty($userId)) {
            return false;
        }
        return $this->dao->getPublishStatus($role_id);
    }

    public function modify($data = array(), $categoryId = null)
    {
        if (empty($data) || empty($categoryId)) {
            return false;
        }
        $this->dao->modify($data, $categoryId);
        return true;
    }
}
