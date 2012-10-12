<?php
/**
 * Blog Model
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_Blog extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_Blog
     */
    protected $dao;

    public function __construct(Speed_Model_Dao_Abstract $dao = null)
    {
        if ($dao) {
            $this->setDao($dao);
        } else {
            $this->setDao(new Admin_Model_Dao_Blog());
        }
    }

    public function getAllStickyBlog()
    {
        return $this->dao->getAllStickyBlog();
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
        $permalink           = new Speed_Utility_Url();
        $authNamespace       = new Zend_Session_Namespace('userInformation');
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['permalink']   = $permalink->getUrl($data['title']);
        $data['create_by']   = $authNamespace->userData['user_id'];
        $blogId              = $this->dao->create($data);
        return $blogId;
    }

    public function setPublishStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }
        $data['last_modaretion_date'] = date('Y-m-d H:i:s');
        $data['permalink']            = $blogId;
        $status                       = $this->getPublishStatus($blogId);
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

    public function setSkStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }
        $data['last_modaretion_date'] = date('Y-m-d H:i:s');
        $data['permalink']            = $blogId;
        $status                       = $this->getSkStatus($blogId);
        if ($status['sticky_on_home_page'] == 1) {
            $data['sticky_on_home_page'] = 0;
        } else {
            $data['sticky_on_home_page'] = 1;
        }
        $this->dao->modify($data, $blogId);
        return true;
    }

    public function getSkStatus($blogId)
    {
        if (empty($blogId)) {
            return false;
        }
        return $this->dao->getSkStatus($blogId);
    }

    public function setPendingStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }
        $data['last_modaretion_date'] = date('Y-m-d H:i:s');
        $data['permalink']            = $blogId;
        $status                       = $this->getPendingStatus($blogId);
        if ($status['status'] == 'publish') {
            $data['status'] = 'pending';
        } else {
            $data['status'] = 'publish';
        }
        $this->dao->modify($data, $blogId);
        return true;
    }

    public function getPendingStatus($blogId)
    {
        if (empty($blogId)) {
            return false;
        }
        return $this->dao->getPendingStatus($blogId);
    }

    public function getAllPublishedBlog()
    {
        return $this->dao->getAllPublishedBlog();
    }

    public function setSelectStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }
        $data['last_modaretion_date'] = date('Y-m-d H:i:s');
        $status                       = $this->getSelectStatus($blogId);
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
        $sticky = $this->getStickeyPost($blogId);
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

    public function getStickeyPost($blogId)
    {
        return $this->dao->getStickyPost($blogId);
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
        $permalink                  = new Speed_Utility_Url();
        $data['permalink']          = $data['blog_id'];
        $data['last_moderate_date'] = date('Y-m-d H:i:s');
        $authNamespace              = new Zend_Session_Namespace('adminInformation');
        $data['last_moderate_by']   = $authNamespace->adminData['admin_id'];
        $data['status']             = 'publish';
        $this->dao->modify($data, $blogId);
        return true;
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

    public function getDetailByPermalink($permalink)
    {
        if (empty($permalink)) {
            return false;
        }
        return $this->dao->getDetailByPermalink($permalink);
    }

    public function getMaxViewBlog()
    {
        return $this->dao->getMaxViewBlog();
    }

    public function updateBlogViewed($blogId, $viewed)
    {
        $data           = array();
        $data['viewed'] = $viewed + 1;
        $this->dao->modify($data, $blogId);
        return true;
    }

    public function getTopBlogger()
    {
        return $this->dao->getTopBlogger();
    }

    public function setTrashStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }
        $data['last_modaretion_date'] = date('Y-m-d H:i:s');
        $data['permalink']            = $blogId;
        $status                       = $this->getTrashStatus($blogId);
        if ($status['status'] == 'admin-trash') {
            $data['status'] = 'pending';
        } else {
            $data['status'] = 'admin-trash';
        }
        $this->dao->modify($data, $blogId);
        return true;
    }

    public function getTrashStatus($blogId)
    {
        if (empty($blogId)) {
            return false;
        }
        return $this->dao->getTrashStatus($blogId);
    }

    public function getAllTrash()
    {
        return $this->dao->getAll();
    }

    public function getAllEpisodeTrash()
    {
        return $this->dao->getAllEpisodeTrash();
    }

    public function setPublishSticky($data, $stickyId)
    {
        if (empty($data) AND (empty($stickyId))) {
            return false;
        }
        $status = $this->getPublishSticky($stickyId);
        if ($status['sticky_on_home_page'] == 1) {
            $data['sticky_on_home_page'] = 0;
        } else {
            $data['sticky_on_home_page'] = 1;
        }
        $this->dao->modify($data, $stickyId);
        return true;
    }

    public function getPublishSticky($stickyId)
    {
        if (empty($stickyId)) {
            return false;
        }
        return $this->dao->getPublishSticky($stickyId);
    }
}
