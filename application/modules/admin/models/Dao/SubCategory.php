<?php
/**
 * Blog category Dao Model
 * @category        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_Dao_SubCategory extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('sub_category', 'subcategory_id');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getDetail($subcategoryId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $subcategoryId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function remove($id = null)
    {
        if (empty ($id)) {
            return false;
        }
        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }
}
