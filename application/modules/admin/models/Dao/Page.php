<?php
/**
 * Page  Dao Model
 * @category        Model
 * @package         Admin
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Dao_Page extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('pages', 'page_id');
    }

    public function getPublish()
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_name}.status =?", 'publish')
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getDetail($pageId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $pageId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getAll()
    {
        $cities = 'page_name';
        if (!empty($cities)) {
            $select = $this->select()
                ->from($this->_name)
                ->order(array("{$this->_primaryKey} DESC"));
            return $this->returnResultAsAnArray($this->fetchAll($select));
        }
    }

    /*
    $query = 'SELECT name FROM user';
if (!empty($cities))
{
   $query .= ' WHERE city IN ('.implode(',',$cities).')';
}

    */
/*

     public function remove($id = null)
            {
        if (empty ($id)) {
            return false;
        }

        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }


     public function getDetail($discussionId)
        {
            $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_primaryKey} =?", $discussionId);

     return $this->returnResultAsAnArray($this->fetchRow($select));
        }


     public function getDetailForAdmin($discussionId)
        {
            $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_primaryKey} =?", $discussionId);

     return $this->returnResultAsAnArray($this->fetchRow($select));
        }


        public function getPublishStatus($discussionId)
        {
            $select = $this->select()
                           ->from($this->_name,array('is_published'))
                           ->where("discussion_id =?", $discussionId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
    */
    public function  getDetailByPagePermalink($permalink)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_name}.permalink =?", $permalink);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getTrashStatus($pageId)
    {
        $select = $this->select()
            ->from($this->_name, array('status'))
            ->where("page_id =?", $pageId)
            ->where("status =?", "admin-trash");
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getAllTrash()
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("pages.status =?", 'admin-trash')
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getPendingStatus($pageId)
    {
        $select = $this->select()
            ->from($this->_name, array('status'))
            ->where("page_id =?", $pageId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
}
