<?php
/**
 * Discussion Dao Model
 *
 * @category        Model
 * @package         Admin
 * @author          Mohammad Zafar Iqbal <zafarmba10104014@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Dao_Discussion extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('discussions', 'discussion_id');
    }

    public function getAll()
    {
        $mystatus = array('publish', 'pending');
        $select   = $this->select()
            ->from($this->_name)
            ->where("discussions.status IN (?)", $mystatus)
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getAllDiscussionTrash()
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("discussions.status =?", 'admin-trash')
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

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
            ->from($this->_name, array('status'))
            ->where("discussion_id =?", $discussionId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
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
            ->setIntegrityCheck(false)
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("{$this->_primaryKey} =?", $discussionId)
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }


    public function getPublishStatus($discussionId)
    {
        $select = $this->select()
            ->from($this->_name,array('status'))
            ->where("discussion_id =?", $discussionId);

        return $this->returnResultAsAnArray($this->fetchRow($select));

    }

    public function getAllPublishDiscussion()
    {

        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('users',"{$this->_name}.create_by = users.user_id")
            ->where("{$this->_name}.status =?",'publish')
            ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
    public function getAllPandingDiscussion()
    {

        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('users',"{$this->_name}.create_by = users.user_id")
            ->where("{$this->_name}.status =?",'pending')
            ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
    public function getTrashStatus($discussionId)
    {
        $select = $this->select()
            ->from($this->_name,array('status'))
            ->where("discussion_id =?", $discussionId);

        return $this->returnResultAsAnArray($this->fetchRow($select));

    }


}
