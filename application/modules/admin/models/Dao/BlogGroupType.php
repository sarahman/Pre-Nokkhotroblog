<?php
/**
 * Group Type Dao Model
 * @category        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Dao_BlogGroupType extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('blog_group_types', 'blog_group_type_id');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function remove($id = null)
    {
        if (empty ($id)) {
            return false;
        }
        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }

    public function getDetail($groupId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $groupId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
}
