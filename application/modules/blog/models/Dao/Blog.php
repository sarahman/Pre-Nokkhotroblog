<?php
/**
 * Blog Dao Model
 *
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */

class Blog_Model_Dao_Blog extends Speed_Model_Dao_Abstract
{
    public function __construct()
    	{
    		parent::__construct();
    		$this->loadTable('blogs','blog_id');

    	}


        public function getAllPostedBlog()
        {
            $select = $this->select()
                           ->from($this->_name)
                           ->setIntegrityCheck(false)
                           ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                           ->join('users',"{$this->_name}.create_by = users.user_id")
                           ->order(array("{$this->_primaryKey} DESC"));

            return $this->returnResultAsAnArray($this->fetchAll($select));
        }


        public function getRecentPosts()
        {
            $select = $this->select()
                           ->from($this->_name)
                           ->setIntegrityCheck(false)
                           ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                           ->join('users',"{$this->_name}.create_by = users.user_id")
                           ->where("blogs.status =?", 'publish')
                           ->where("{$this->_name}.create_date >= ( CURDATE() - INTERVAL 7 DAY )")
                           ->order(array("{$this->_name}.last_modaretion_date DESC"))
                           ->limit(10);


            return $this->returnResultAsAnArray($this->fetchAll($select));

        }

        public function getAllPostCount()
        {
            $select = $this->select()
                           ->from($this->_name, array('total' => new Zend_Db_Expr('count(*)')));

            $result = $this->fetchRow($select);
                        return empty($result) ? 0 : $result->total;

        }
	public function getTopBlogger()
    {

        $select = "SELECT username, user_id, create_by, profile_picture, name, display_name, blog_id, COUNT( create_by ) AS no
FROM  `blogs`
INNER JOIN  `users` ON blogs.create_by = users.user_id
WHERE  `status` =  'publish'
GROUP BY create_by
ORDER BY no DESC
LIMIT 10";

        return $this->returnResultAsAnArray($this->getDefaultAdapter()->fetchAll(($select)));
    }
        public function getSelectedPosts()
        {
            $select = $this->select()
                           ->from($this->_name)
                           ->setIntegrityCheck(false)
                           ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                           ->join('users',"{$this->_name}.create_by = users.user_id")
                           ->where("blogs.status =?", 'publish')
                           ->where("blogs.post_type =?", 'blog')
 			   ->where("{$this->_name}.is_selected =?",1)
                           ->order(array("{$this->_primaryKey} DESC"))
                           ->limit(5);

            return $this->returnResultAsAnArray($this->fetchAll($select));
        }

        public function getUserPosts($userId)
        {
            $select = $this->select()
                           ->from($this->_name)
                           ->setIntegrityCheck(false)
                           ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                           ->join('users',"{$this->_name}.create_by = users.user_id")
                           ->where("blogs.status =?", 'publish')
                           ->where("blogs.post_type =?", 'blog')
                           ->where('blogs.create_by =?', $userId)
                           ->order(array("{$this->_primaryKey} DESC"))
                           ->limit(15);

            return $this->returnResultAsAnArray($this->fetchAll($select));
          }
		  public function getUserPostsTotal($userId)
        {
            $select = $this->select()
                           ->from($this->_name, array('total' => new Zend_Db_Expr('count(*)')))
						  ->where('blogs.create_by =?', $userId);

            return $this->returnResultAsAnArray($this->fetchAll($select));
          }
		/*public function getUserCommentsTotal($userId)
        {
            $select = $this->select()
                           ->from($this->comments, array('total' => new Zend_Db_Expr('count(*)')))
						  ->where('comments.create_by =?', $userId);

            return $this->returnResultAsAnArray($this->fetchAll($select));
          }*/
        public function getPublishStatus($blogId)
        {
            $select = $this->select()
                           ->from($this->_name,array('is_published'))
                           ->where("blog_id =?", $blogId)
                           ->where("blogs.post_type =?", 'blog');

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }

        public function getSelectStatus($blogId)
           {
               $select = $this->select()
                              ->from($this->_name,array('is_selected'))
                              ->where("blog_id =?", $blogId)
                              ->where("blogs.post_type =?", 'blog')
                              ->where("blogs.status =?", 'publish'); 
               return $this->returnResultAsAnArray($this->fetchRow($select));

           }

        public function getStickeyPost()
        {
            $select = $this->select()
                           ->from($this->_name)
                           ->where("sticky_on_home_page =?",1)
                           ->where("blogs.post_type =?", 'blog')
                           ->order(array("{$this->_primaryKey} DESC"))
                           ->limit(1);

            return $this->returnResultAsAnArray($this->fetchAll($select));
        }


        public function getRowCount(array $searchKey)
        {
            $select = $this->select()
                           ->from($this->_name,
                                array('total' => new Zend_Db_Expr('count(*)')));

            $select = $this->setQuerySegments($select, $searchKey);

            $result = $this->fetchRow($select);
            return empty($result) ? 0 : $result->total;
        }

        public function getDetail($blogId)
        {
            $select = $this->select()
                ->from($this->_name)
                ->setIntegrityCheck(false)
                ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                ->join('users',"{$this->_name}.create_by = users.user_id")
                ->where("{$this->_primaryKey} =?", $blogId);

            return $this->returnResultAsAnArray($this->fetchRow($select));
        }

        public function getDetailForAdmin($blogId)
            {
                $select = $this->select()
                    ->from($this->_name)
                    ->setIntegrityCheck(false)
                    ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                    ->join('users',"{$this->_name}.create_by = users.user_id")
                    ->where("{$this->_primaryKey} =?", $blogId);

                return $this->returnResultAsAnArray($this->fetchRow($select));
            }

        public function remove($blogId = null)
    	{
    		if (empty ($blogId)) {
    			return false;
    		}

    		return parent::delete("{$this->_primaryKey} = '{$blogId}'");
    	}

    public function getDetailByPermalink($permalink)
    {
        $select = $this->select()
                ->from($this->_name)
                ->setIntegrityCheck(false)
                ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                ->join('users',"{$this->_name}.create_by = users.user_id")
                ->where("{$this->_name}.permalink =?", $permalink);

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getMaxViewBlog()
    {
        $select = $this->select()
                           ->from($this->_name)
                           ->setIntegrityCheck(false)
                           ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                           ->join('users',"{$this->_name}.create_by = users.user_id")
                           ->where("blogs.status =?", 'publish')
                           ->where("blogs.post_type =?", 'blog')
                           ->order(array("blogs.viewed DESC"))
                           ->limit(15);

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    
    public function getBlogtrash($userId)
    {

        $select = $this->select()
                       ->from($this->_name)
                       ->where("{$this->_name}.status =?", 'trash')
                       ->where("{$this->_name}.post_type =?", 'blog')
                       ->where("{$this->_name}.create_by =?", $userId)  
                       ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
    public function getDetailByCategory($id)
    {
        $select = $this->select()
                       ->from($this->_name)
                       ->setIntegrityCheck(false)
                       ->join('blog_categories', "{$this->_name}.blog_category_id = blog_categories.blog_category_id")
                       ->join('users',"{$this->_name}.create_by = users.user_id")
                       ->where("{$this->_name}.status =?", 'publish')
                       ->where("{$this->_name}.post_type =?", 'blog')
                       ->where("{$this->_name}.blog_category_id =?", $id)
                       ->order(array("blogs.viewed DESC"));

                return $this->returnResultAsAnArray($this->fetchAll($select));

    }

    public function getDetailByCategoryId($id)
    {
        $select = $this->select()
                       ->from($this->_name)
                       ->setIntegrityCheck(false)
                       ->join('blog_categories', "{$this->_name}.blog_category_id = blog_categories.blog_category_id")
                       ->join('users',"{$this->_name}.create_by = users.user_id")
                       ->where("{$this->_name}.status =?", 'publish')
                       ->where("{$this->_name}.post_type =?", 'blog')
                       ->where("{$this->_name}.blog_category_id =?", $id)
                       ->order(array("blogs.last_modaretion_date DESC"));

                return $this->returnResultAsAnArray($this->fetchAll($select));

    }


}
