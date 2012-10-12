<?php
/**
 * DiscussionComment Dao Model
 * @category        Model
 * @package         Blog
 * @author          Mohammad Zafar Iqbal <zafarmba10104014@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_Dao_DiscussionComment extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('discussion_comments', 'discussion_comment_id');
    }

    public function getAll($discussionId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("is_published =1")
            ->where("discussion_id =?", $discussionId)
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getDetail($groupId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $groupId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getDetailForAdmin($discussionId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $discussionId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
}
