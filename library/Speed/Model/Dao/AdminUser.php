<?php
/**
 * User Dao
 * @category    Dao
 * @package     Library
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 * @author      Eftakhairul Islam <eftakhairul@gmail.com>
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://www.rightbrainsolution.com)
 */
class Speed_Model_Dao_AdminUser extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('admins', 'admin_id');
    }

    public function validateUser($data)
    {

        $select = $this->select()
            ->from($this->_name, array($this->_primaryKey, 'username', 'role_id', 'email_address'))
            ->where("username = '{$data['username']}'")
            ->where("password = '{$data['password']}'");

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getActivationCode($data)
    {
        $select = $this->select()
            ->from($this->_name, array('activation_code', 'username'))
            ->where("email_address = '{$data['email_address']}'");

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function updatePassword($data, $activationCode)
    {
        return parent::update($data, "activation_code = '{$activationCode}'");
    }

    public function getDetail($userId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("admin_id = ?", $userId);

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getSummary($options = array())
    {
        $select = $this->select()
            ->from($this->_name, array($this->_primaryKey, 'username', 'email_address', 'last_login', 'status' => 'user_status'));

        $select = $this->setQuerySegments($select, $options)
            ->order(array("{$this->_primaryKey} ASC"))
            ->limit($options['total'], $options['offset']);

        return $this->returnResultAsAnArray($this->fetchAll($select));
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
}
