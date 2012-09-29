<?php
/**
 * Blog Dao Model
 *
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_Model_Dao_Comment extends Speed_Model_Dao_Abstract
{
    public function __construct()
    	{
    		parent::__construct();
    		$this->loadTable('comments','comment_id');

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
                           ->where("blogs.is_published =?", 1)
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

        public function getSelectedPosts()
        {
            $select = $this->select()
                           ->from($this->_name)
                           ->setIntegrityCheck(false)
                           ->join('blog_categories', "blog_categories.blog_category_id = {$this->_name}.blog_category_id")
                           ->join('users',"{$this->_name}.create_by = users.user_id")
                           ->where("blogs.is_published =?", 1)
                           ->where("blogs.is_selected =?", 1)
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
                           ->where("blogs.is_published =?", 1)
                           ->where("blogs.is_selected =?", 1)
                           ->where('blogs.create_by =?', $userId)
                           ->order(array("{$this->_primaryKey} DESC"))
                           ->limit(15);

            return $this->returnResultAsAnArray($this->fetchAll($select));
          }

        public function getPublishStatus($blogId)
        {
            $select = $this->select()
                           ->from($this->_name,array('is_published'))
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

        public function getStickeyPost()
        {
            $select = $this->select()
                           ->from($this->_name,array($this->_primaryKey,'sticky_on_home_page'))
                           ->where("sticky_on_home_page =?",1);

            //var_dump($this->returnResultAsAnArray($this->fetchAll($select)));die;
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
                ->where("blogs.is_published =?", 1)
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

        public function getCompletedExams($options = array())
        {
            $select = $this->select()
                           ->setIntegrityCheck(false)
                           ->from($this->_name, array($this->_primaryKey, 'exam_code', 'name', 'concentration'))
                           ->join('results', "results.{$this->_primaryKey} = {$this->_name}.{$this->_primaryKey}",
                                   array('no_of_students' => new Zend_Db_Expr("COUNT(results.user_id)")))
                           ->join('teacher_courses', "teacher_courses.{$this->_primaryKey} = {$this->_name}.{$this->_primaryKey}", array())
                           ->join('courses', 'courses.course_id = teacher_courses.course_id', array('course_code', 'course_title' => 'title'))
                           ->where('exam_status = ?', $options['exam_status'])
                           ->group("{$this->_name}.{$this->_primaryKey}")
                           ->order(array("{$this->_name}.{$this->_primaryKey} ASC"))
                           ->limit($options['total'], $options['offset']);

            if (!empty($options['exam_code'])) {
                $select->where('exam_code LIKE ?', '%' . $options['exam_code'] . '%');
            }

            return $this->returnResultAsAnArray($this->fetchAll($select));
        }

        public function getCompletedExamsRowCount(array $options)
        {
            $select = $this->select()
                           ->setIntegrityCheck(false)
                           ->from($this->_name, array())
                           ->join('results', "results.{$this->_primaryKey} = {$this->_name}.{$this->_primaryKey}",
                                   array('total' => new Zend_Db_Expr("COUNT(results.user_id)")))
                           ->where('exam_status = ?', $options['exam_status'])
                           ->group("{$this->_name}.{$this->_primaryKey}");

            if (!empty($options['exam_code'])) {
                $select->where('exam_code LIKE ?', '%' . $options['exam_code'] . '%');
            }

            $result = $this->fetchRow($select);
            return empty($result) ? 0 : $result->total;
        }

        protected function setQuerySegments(Zend_Db_Table_Select $select, $options = array())
        {
            $select->setIntegrityCheck(false)
                   ->join('teacher_courses', "teacher_courses.{$this->_primaryKey} = {$this->_name}.{$this->_primaryKey}", array())
                   ->join('courses', 'teacher_courses.course_id = courses.course_id', array('course_code'));

            if (!empty($options['keywords'])) {
                $select->where('name LIKE ?', '%' . $options['keywords'] . '%');
            }

            if (!empty($options['exam_status'])) {
                $select->where('exam_status = ?', $options['exam_status']);
            }

            if (!empty($options['semester_id'])) {
                $select->where('semester_id = ?', $options['semester_id']);
            }

            return $select;
        }
}
