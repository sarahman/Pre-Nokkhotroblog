<?php

/**
 * Role Dao
 * @category    Dao
 * @package     User
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://rightbrainsolution.com)
 */
class User_Model_Dao_Role extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('roles', 'role_id');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name)
            ->order("{$this->_primaryKey} DESC");
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function save($data)
    {
        return $this->create($data);
    }

    public function update($data)
    {
        $data = $this->removeNonAttributes($data);
        return parent::update($data, "{$this->_primaryKey} = ?", $data[$this->_primaryKey]);
    }
}