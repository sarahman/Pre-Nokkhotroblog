<?php
/**
 * Blog Model
 *
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_Blog extends Speed_Model_Abstract
{
    protected $dao;

    public function __construct(Speed_Model_Dao_Abstract $dao = null)
    {
        if ($dao) {
            $this->setDao($dao);
        } else {
            $this->setDao(new Blog_Model_Dao_Blog());
        }
    }

    public function getAllPostedBlog()
    {
        return $this->dao->getAllPostedBlog();
    }

    public function save($data = array())
    {
        if (empty($data)) {
            return false;
        }

        $permalink = new Speed_Utility_Url();
        $authNamespace = new Zend_Session_Namespace('userInformation');

        $data['create_date'] = date('Y-m-d H:i:s');
        $data['permalink'] = $permalink->getUrl($data['title']);
        $data['create_by'] = $authNamespace->userData['user_id'];
        $data['post_type'] = 'blog';
        $blogId = $this->dao->create($data);

        return $blogId;
    }

    public function setPublishStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }

        $data['last_modaretion_date'] = date('Y-m-d H:i:s');

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

    public function setSelectStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }

        $data['last_modaretion_date'] = date('Y-m-d H:i:s');


        $status = $this->getSelectStatus($blogId);

        if ($status['is_selected'] == 1) {

            $data['is_selected'] = 0;
        } else {
            $data['is_selected'] = 1;
        }

        $this->dao->modify($data, $blogId);

        return true;
    }

    public function getSelectStatus($blogId)
    {
        if (empty($blogId)) {
            return false;
        }

        return $this->dao->getSelectStatus($blogId);
    }

    public function setStickyPost($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }

        $sticky = $this->getStickeyPost();


        if (!empty($sticky)) {
            if ($sticky[0]['sticky_on_home_page'] == 1) {

                $data['sticky_on_home_page'] = 0;

                $this->dao->modify($data, $sticky[0]['blog_id']);
            }
        } else {
            $data['sticky_on_home_page'] = 1;
        }

        $this->dao->modify($data, $blogId);

        return true;
    }

    public function getStickeyPost()
    {

        return $this->dao->getStickeyPost();
    }

    public function getRecentPosts()
    {
        return $this->dao->getRecentPosts();
    }




    public function getSelectedPosts()
    {
        return $this->dao->getSelectedPosts();
    }

    public function getDetailForAdmin($blogId)
    {
        if (empty ($blogId)) {
            return false;
        }

        $record = $this->dao->getDetailForAdmin($blogId);

        return $record;
    }
    

    public function getUserPosts($userId)
    {
        if (empty($userId)) {
            return false;
        }

        return $this->dao->getUserPosts($userId);
    }

    public function modify($data = array(), $blogId = null)
    {
        if (empty($data) || empty($blogId)) {
            return false;
        }

        $permalink = new Speed_Utility_Url();
        $data['permalink'] = $permalink->getUrl($data['title']);

        $data['update_date'] = date('Y-m-d H:i:s');
        $authNamespace = new Zend_Session_Namespace('userInformation');
        $data['update_by'] = $authNamespace->userData['user_id'];
        $data['is_published'] = 0;

        $this->dao->modify($data, $blogId);
        return true;
    }

    public function delete($blogId = null)
    {
        if (empty($blogId)) {
            return false;
        }

        return $this->dao->remove($blogId);
    }

    protected function formatDate($date)
    {
        $temporaryDate = new Zend_Date($date, 'MM/dd/y');
        return $temporaryDate->toString('y-MM-dd');
    }

    public function getSummary($options = array())
    {
        if (empty ($options)) {
            return array();
        }

        $options = $this->checkData($options);
        return $this->dao->getSummary($this->setCountOffset($options));
    }

    public function getRowCount(array $options)
    {
        if (empty ($options)) {
            return 0;
        }

        $options = $this->checkData($options);
        return $this->dao->getRowCount($options);
    }

    public function getAllPostCount()
    {
        return $this->dao->getAllPostCount();
    }

    protected function checkData(array $options)
    {
        if (empty($options['semester_id'])) {
            $semesterModel = new Devnet_Model_Semester();
            $options['semester_id'] = $semesterModel->getCurrentSemesterId();
        }

        return $options;
    }

    public function getCompletedExams($options = array())
    {
        $options['exam_status'] = Exam_Model_ExamStatus::ARCHIVE;
        return $this->dao->getCompletedExams($this->setCountOffset($options));
    }

    public function getCompletedExamsRowCount(array $options)
    {
        $options['exam_status'] = Exam_Model_ExamStatus::ARCHIVE;
        return $this->dao->getCompletedExamsRowCount($options);
    }

    public function getFullExamName($examId = null)
    {
        if (empty($examId)) {
            return '';
        }

        $teacherCourseModel = new Exam_Model_TeacherCourse();
        $result = $teacherCourseModel->getDetails(array('exam_id' => $examId));

        return $result['semester_title'] . " " . $result['course_title'] . " " . $result['exam_title'];
    }

    public function getDetailByPermalink($permalink)
    {
        if (empty($permalink)){
            return false;
        }

        return $this->dao->getDetailByPermalink($permalink);
    }

    public function getMaxViewBlog()
    {
        return $this->dao->getMaxViewBlog();
    }

    public function updateBlogViewed($blogId,$viewed)
    {

        $data = array();

        $data['viewed'] = $viewed + 1;

        $this->dao->modify($data, $blogId);

        return true;
    }

    public function getTopBlogger()
    {
        return $this->dao->getTopBlogger();
    }
    
    public function getBlogtrash($userId)
	{
	return $this->dao->getBlogtrash($userId);

	}

 public function getDetailByCategoryId($id)
    {
        if(empty($id)){
            return false;
        }
        $record = $this->dao->getDetailByCategoryId($id);

        return $record;

      
    }
   public function getDetailByCategory($id)
    {
        if(empty($id)){
            return false;
        }
        $record = $this->dao->getDetailByCategory($id);

        return $record;

      
    }


}
