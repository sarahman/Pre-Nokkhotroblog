<?php
/**
 * Blog comment Model
 * @comment        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_BlogComment extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_BlogComment
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_BlogComment();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getDetailForComment($commentId)
    {
        if (empty ($commentId)) {
            return false;
        }
        $record = $this->dao->getDetailForComment($commentId);
        return $record;
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $authNamespace        = new Zend_Session_Namespace('userInformation');
        $data['is_published'] = 1;
        $data['create_date']  = date('Y-m-d H:i:s');
        $data['create_by']    = $authNamespace->userData['user_id'];
        $commentId            = $this->dao->create($data);
        return $commentId;
    }

    public function setPublishStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }
        $status = $this->getPublishStatus($blogId);
        if ($status['is_published'] == 1) {
            $data['is_published'] = 0;
        } else {
            $data['is_published'] = 1;
        }
        $this->dao->modify($data, $blogId);
        return true;
    }

    public function getPublishStatus($blogId)
    {
        if (empty($blogId)) {
            return false;
        }
        return $this->dao->getPublishStatus($blogId);
    }

    public function modify($data = array(), $commentId = null)
    {
        if (empty($data) || empty($commentId)) {
            return false;
        }
        $data['update_date'] = date('Y-m-d H:i:s');
        $this->dao->modify($data, $commentId);
        return true;
    }

    public function getCommentsByBlogId($blogId)
    {
        if (empty($blogId)) {
            return false;
        }
        return $this->dao->getCommentsByBlogId($blogId);
    }

    public function getCommentsByUserId($userId)
    {
        if (empty($userId)) {
            return false;
        }
        return $this->dao->getCommentsByUserId($userId);
    }

    public function getMaxCommentedBlog()
    {
        return $this->dao->getMaxCommentedBlog();
    }

    public function updateTotalCommentCount($comment, $commentId)
    {
        $data                   = array();
        $data['total_comments'] = $comment['total_comments'] + 1;
        $this->dao->modify($data, $commentId);
        return true;
    }

    public function getRecentComments()
    {
        return $this->dao->getRecentComments();
    }

    public function getTopCommentPoster()
    {
        return $this->dao->getTopCommentPoster();
    }

    public function countComment($postId)
    {
        return $this->dao->countComment($postId);
    }

    //public function getCommentByCatagoryId($id)
    //   {
    //
    //      $select=" SELECT blog_id, count( comment_id ) AS no FROM  `comments` where blog_id=$id GROUP BY blog_id ORDER BY no DESC";
    //       return $this->returnResultAsAnArray($this->getDefaultAdapter()->fetchAll($select));
    //  }
    public function getCommentByUser($userComment)
    {
        return $this->dao->getCommentByUser($userComment);
    }
}
