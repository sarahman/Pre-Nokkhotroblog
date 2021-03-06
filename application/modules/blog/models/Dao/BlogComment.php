<?php
/**
 * Blog category Dao Model
 *
 * @category        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_Dao_BlogComment extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('comments', 'comment_id');
    }

    public function getDetailForComment($commentId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('blogs', "{$this->_name}.blog_id = blogs.blog_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("{$this->_primaryKey} =?", $commentId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getcommentPosts()
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('blogs', "blogs.blog_id = {$this->_name}.blog_id")
            ->where("comments.is_published =?", 1)
            ->order(array("{$this->_primaryKey} DESC"))
            ->limit(5);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getPublishStatus($blogId)
    {
        $select = $this->select()
            ->from($this->_name, array('is_published'))
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

    public function getCommentsByBlogId($blogId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('blogs', "blogs.blog_id = {$this->_name}.blog_id")
            ->join('users', "users.user_id  = {$this->_name}.create_by")
            ->where("{$this->_name}.blog_id =?", $blogId)
            ->where("{$this->_name}.is_published =?", 1)
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getCommentsByUserId($userId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('blogs', "blogs.blog_id = {$this->_name}.blog_id")
            ->join('users', "users.user_id  = {$this->_name}.create_by")
            ->where("{$this->_name}.create_by =?", $userId)
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getMaxCommentedBlog()
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('blogs', "{$this->_name}.blog_id = blogs.blog_id")
            ->join('blog_categories', "blog_categories.blog_category_id = blogs.blog_category_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("blogs.status =?", 'publish')
            ->where("{$this->_name}.is_published =?", 1)
            ->order(array("{$this->_name}.total_comments DESC"))
            ->limit(5);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    /*public function getRecentComments()
    {
        $select = $this->select()
                       ->from($this->_name)
->setIntegrityCheck(false)
                       ->where("{$this->_name}.is_published =?", 1)
                       ->order(array("{$this->_primaryKey} DESC"))
                       ->limit(15);

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }*/
    public function getRecentComments()
    {
        $select = $this->select()
                       ->from($this->_name)
                       ->setIntegrityCheck(false)
                       ->join('blogs',"blogs.blog_id=comments.blog_id")
                       ->join ('users',"blogs.create_by=users.user_id")
                       ->where("{$this->_name}.is_published =?", 1)
                       ->order(array("{$this->_primaryKey} DESC"))
                       ->limit(15);

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getTopCommentPoster()
    {
        //$select = "SELECT DISTINCT username FROM `comments` INNER JOIN `blogs` ON comments.blog_id = blogs.blog_id INNER JOIN `users` ON comments.create_by = users.user_id WHERE (blogs.is_published =1) AND (comments.is_published =1) ORDER BY `comments`.`total_comments` DESC LIMIT 10";
        $select = " SELECT username, create_by,display_name,profile_picture,name, comment_id, COUNT(create_by) AS no FROM comments INNER JOIN users ON comments.create_by=users.user_id GROUP BY create_by ORDER BY no DESC LIMIT 10";
        return $this->returnResultAsAnArray($this->getDefaultAdapter()->fetchAll($select));
    }

    public function countComment($postId)
    {
        $select = "SELECT blog_id, count( comment_id ) AS no FROM  `comments` where blog_id=$postId GROUP BY blog_id ORDER BY no DESC";
        return $this->returnResultAsAnArray($this->getDefaultAdapter()->fetchAll($select));
    }

//	public function countComment($postId)
//    {
    //      $select=" SELECT blog_id, count( comment_id ) AS no FROM  `comments` where blog_id=$postId GROUP BY blog_id ORDER BY no DESC";
    //       return $this->returnResultAsAnArray($this->getDefaultAdapter()->fetchAll($select));
    //   }
    public function getCommentByUser($userComment)
    {
        $select = "SELECT username, create_by,comment_id,comments, COUNT(comments) AS no FROM comments INNER JOIN users ON comments.create_by=users.user_id WHERE users.username='$userComment' GROUP BY comments ORDER BY no DESC LIMIT 5";
        return $this->returnResultAsAnArray($this->getDefaultAdapter()->fetchAll($select));
    }
}
