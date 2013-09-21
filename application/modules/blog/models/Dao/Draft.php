<?php
/**
 * Draft Dao Model
 * @Draft        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_Dao_Draft extends Speed_Model_Dao_Abstract
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
            ->where("{$this->_name}.status =?", 'draft');
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getDraftl($draftId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $draftId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getTrashStatus($blogId)
    {
        $select = $this->select()
            ->from($this->_name, array('status'))
            ->where("blog_id =?", $blogId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
}
