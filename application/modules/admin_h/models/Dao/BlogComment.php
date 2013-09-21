<?php
/**
 * Blog category Dao Model
 *
 * @category        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_Dao_BlogComment extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('comments','comment_id');
    }


    public function getAll()
    {

        $select = $this->select()
                       ->from($this->_name);

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
    
    // Mohammad Zafar Iqbal Sep22
      public function getAllCommentTrash()
    {

        $select = $this->select()
                       ->from($this->_name)
                        ->where("status =?", 'admin-trash');
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
public function getAllComment()
    {

        $select = $this->select()
                       ->from($this->_name)
                       ->setIntegrityCheck(false)
                       ->join('blogs', "blogs.blog_id = {$this->_name}.blog_id")
		       ->join('users',"{$this->_name}.create_by = users.user_id")
                       ->where("comments.status =?", 1)
		       ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

     public function getDetailForAdmin($blogId)
            {
                $select = $this->select()
                    ->from($this->_name)
                    ->setIntegrityCheck(false)
                    ->join('blogs', "blogs.blog_id = {$this->_name}.blog_id")
                    ->join('users',"{$this->_name}.user_id = users.user_id")
                    ->where("{$this->_primaryKey} =?", $blogId);

                return $this->returnResultAsAnArray($this->fetchRow($select));
            }

	
        public function getPublishStatus($blogId)
        {
            $select = $this->select()
                           ->from($this->_name,array('is_published'))
                           ->where("comment_id =?", $blogId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }


	 public function getDetail($commentId)
        {
            $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_primaryKey} =?", $commentId);

            return $this->returnResultAsAnArray($this->fetchRow($select));
        }
	

	 public function remove($id = null)
    		{
        if (empty ($id)) {
            return false;
        }

        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }
    
// For Trash Sep 22 MOHAMMAD ZAFAR IQBAL
     public function getTrashStatus($blogId)
        {
            $select = $this->select()
                           ->from($this->_name,array('status'))
                           ->where("comment_id =?", $blogId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }

    public function getCommentByBlog($commentsId)
    {
	  $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            //->join('notices', "{$this->_name}.notice_id= notices.notice_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
	    //->where("{$this->_name}.is_published =?",1)
	    ->where("{$this->_name}.status =?",0)
            ->where("blog_id=?", $commentsId)

            ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

        public function getPendingStatus($commentId)
        {
            $select = $this->select()
                           ->from($this->_name,array('status'))
                           ->where("comment_id =?", $commentId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
	

}
