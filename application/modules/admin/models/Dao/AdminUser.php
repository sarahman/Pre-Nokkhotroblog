<?php
/**
 * Blog category Dao Model
 * @category        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_Dao_AdminUser extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('admins', 'admin_id');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getDetailForAdmin($userId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where('admin_id=?', $userId);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function validateUser($data)
    {
        $select = $this->select()
            ->from($this->_name, array($this->_primaryKey, 'username', 'role_id', 'email_address'))
            ->where("username        = '{$data['username']}'")
            ->where("password        = '{$data['password']}'")
            ->where("user_status     = 'active'");
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    // public function getDetail($userId)
    // {
    //$select = $this->select()
    // ->from($this->_name)
    // ->where("user_id = ?", $userId);
    // return $this->returnResultAsAnArray($this->fetchRow($select));
    //}
    public function getDetail($postId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $postId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    protected function setQuerySegments(Zend_Db_Table_Select $select, $options = array())
    {
        $select->setIntegrityCheck(false)
            ->join('roles', "{$this->_name}.role_id = roles.role_id",
                   array('role' => 'title'));
        return $select;
    }

    public function getAllUsers()
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("user_status =?", "active")
            ->order($this->_primaryKey)
            ->limit(20);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function remove($id = null)
    {
        if (empty ($id)) {
            return false;
        }
        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }

    public function getDetailByUsername($username)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("username = ?", $username);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getSelectStatus($userId)
    {
        $select = $this->select()
            ->from($this->_name, array('user_status'))
            ->where("admin_id =?", $userId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
}

