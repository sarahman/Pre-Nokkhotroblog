<?php
/**
 * Blog Dao Model
 *
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_Dao_Blog extends Speed_Model_Dao_Abstract
{
    public function __construct()
    	{
    		parent::__construct();
    		$this->loadTable('blogs','blog_id');

    	}

        public function getSummary($options = array())
        {
            $select = $this->select()
                            ->from($this->_name, array($this->_primaryKey,'exam_id', 'exam_code', 'name', 'total_questions', 'exam_status'));

            $select = $this->setQuerySegments($select, $options)
                           ->order(array("{$this->_primaryKey} ASC"))
                           ->limit($options['total'], $options['offset']);

    		return $this->returnResultAsAnArray($this->fetchAll($select));
        }

        public function getAllPostedBlog()
        {
            $select = $this->select()
                           ->from($this->_name)
                           ->setIntegrityCheck(false)
                           ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                           ->join('users',"{$this->_name}.create_by = users.user_id")
                           ->where("{$this->_name}.status =?",'pending')
                           ->where("{$this->_name}.post_type =?",'blog')
                           ->order(array("{$this->_primaryKey} DESC"));



            return $this->returnResultAsAnArray($this->fetchAll($select));
        }

  public function getAllPublishedBlog()
        {
            $select = $this->select()
                           ->from($this->_name)
                           ->setIntegrityCheck(false)
                           ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                           ->join('users',"{$this->_name}.create_by = users.user_id")
                           ->where("{$this->_name}.status =?",'publish')
                           ->where("{$this->_name}.post_type =?",'blog')
                           ->order(array("{$this->_primaryKey} DESC"));

            return $this->returnResultAsAnArray($this->fetchAll($select));
        }


        public function getAllPostCount()
        {
            $select = $this->select()
                           ->from($this->_name, array('total' => new Zend_Db_Expr('count(*)')));

            $result = $this->fetchRow($select);
                        return empty($result) ? 0 : $result->total;

        }

        public function getPublishStatus($blogId)
        {
            $select = $this->select()
                           ->from($this->_name,array('is_published'))
                           ->where("blog_id =?", $blogId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
        // Stky
         public function getSkStatus($blogId)
        {
            $select = $this->select()
                           ->from($this->_name,array('sticky_on_home_page'))
                           ->where("blog_id =?", $blogId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
        public function getPendingStatus($blogId)
        {
            $select = $this->select()
                           ->from($this->_name,array('status'))
                           ->where("blog_id =?", $blogId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }

        public function getSelectStatus($blogId)
           {
               $select = $this->select()
                              ->from($this->_name,array('is_selected'))
                              ->where("blog_id =?", $blogId);

               return $this->returnResultAsAnArray($this->fetchRow($select));

           }

        public function getStickeyPost($blogId)
        {
            $select = $this->select()
                           ->from($this->_name,array($this->_primaryKey,'sticky_on_home_page'))
                           ->where("sticky_on_home_page =?",1)
                           ->where("{$this->_name}.blog_id =?", $blogId);

            return $this->returnResultAsAnArray($this->fetchRow($select));
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
                ->where("blogs.is_published =?", 1)
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
                ->where("blogs.is_published =?", 1)
                ->where("{$this->_name}.permalink =?", $permalink);

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

        public function getTrashStatus($blogId)
        {
            $select = $this->select()
                           ->from($this->_name,array('status'))
                           ->where("blog_id =?", $blogId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
 
        public function getAll()
    	{
        $select = $this->select()
                       ->from($this->_name)
                         ->where("{$this->_name}.post_type =?",'blog')
                        ->where("blogs.status =?", 'admin-trash');

        return $this->returnResultAsAnArray($this->fetchAll($select));
    	}

        public function getAllEpisodeTrash()
    	{
        $select = $this->select()
                       ->from($this->_name)
                     ->where("blogs.post_type =?", 'episode')
                       ->where("blogs.status =?", 'admin-trash');

        return $this->returnResultAsAnArray($this->fetchAll($select));
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
public function getAllstickyBlog()
        {
            $select = $this->select()
                           ->from($this->_name)
                           ->where("{$this->_name}.status=?",'publish')
			   ->where("{$this->_name}.sticky_on_home_page=?",1)
                           ->order(array("{$this->_primaryKey} DESC"));



            return $this->returnResultAsAnArray($this->fetchAll($select));
        }
        public function getPublishSticky($stickyId)
        {
            $select = $this->select()
                           ->from($this->_name,array('sticky_on_home_page'))
                           ->where("blog_id =?", $stickyId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }

}
