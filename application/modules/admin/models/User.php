<?php
/**
 * users Model
 * @users        Model
 * @package         admin
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_User extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_User
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_User();
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

    public function setPublishStatus($data, $userId)
    {
        if (empty($data) AND (empty($userId))) {
            return false;
        }
        $status = $this->getPublishStatus($userId);
        if ($status['user_status'] == 'active') {
            $data['user_status'] = 'in-active';
        } else {
            $data['user_status'] = 'active';
        }
        $this->dao->modify($data, $userId);
        return true;
    }

    public function getPublishStatus($userId)
    {
        if (empty($userId)) {
            return false;
        }
        return $this->dao->getPublishStatus($userId);
    }

    public function setBannedStatus($data, $userId)
    {
        if (empty($data) AND (empty($userId))) {
            return false;
        }
        $status = $this->getBannedStatus($userId);
        if ($status['user_status'] == 'banned') {
            $data['user_status'] = 'allow';
        } else {
            $data['user_status'] = 'banned';
        }
        $this->dao->modify($data, $userId);
        return true;
    }

    public function getBannedStatus($userId)
    {
        if (empty($userId)) {
            return false;
        }
        return $this->dao->getBannedStatus($userId);
    }
}
