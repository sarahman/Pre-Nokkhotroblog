<?php
/**
 * Draft Dao Model
 * @Draft        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_Model_Dao_Trash extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('blogs', 'blog_id');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_name}.status =?", 'trash');
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
}