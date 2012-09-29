<?php
/**
 * Blog category Dao Model
 *
 * @category        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_Dao_NoticComment extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('comments_notice', 'comment_notice_id');
    }

    public function getDetailForComment($commentId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('notices', "{$this->_name}.notice_id= notices.notice_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("{$this->_primaryKey} =?", $commentId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getAll($commentsId)
    {
	  $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            //->join('notices', "{$this->_name}.notice_id= notices.notice_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
	    ->where("{$this->_name}.is_published =?",1)
            ->where("notice_id=?", $commentsId)

            ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getAllPublished()
    {
	  $select = $this->select()
            ->from($this->_name)
	    ->where("{$this->_name}.is_published =?",1)
            ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
    public function getAllPanding()
    {
	  $select = $this->select()
            ->from($this->_name)
	    ->where("{$this->_name}.is_published =?",0)
            ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getPublishStatus($commentId)
    {
        $select = $this->select()
            ->from($this->_name, array('is_published'))
            ->where("comment_notice_id =?", $commentId);

        return $this->returnResultAsAnArray($this->fetchRow($select));

    }


    public function getDetail($commentId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $commentId);

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }


    public function remove($commentId = null)
    {
        if (empty ($commentId)) {
            return false;
        }

        return parent::delete("{$this->_primaryKey} = '{$commentId}'");
    }

}
