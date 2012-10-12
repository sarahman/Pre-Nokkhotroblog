<?php
/**
 * Group Type Model
 * @category        Model
 * @package         Group type
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_BlogGroup extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_BlogGroup
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_BlogGroup();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $data['create_date'] = date('Y-m-d H:i:s');
        $authNamespace       = new Zend_Session_Namespace('adminInformation');
        $data['create_by']   = $authNamespace->adminData['admin_id'];
        $postId              = $this->dao->create($data);
        return $postId;
    }

    public function modify($data = array(), $groupId = null)
    {
        if (empty($data) || empty($groupId)) {
            return false;
        }
        $data['update_date'] = date('Y-m-d H:i:s');
        $authNamespace       = new Zend_Session_Namespace('adminInformation');
        $data['update_by']   = $authNamespace->adminData['admin_id'];
        $this->dao->modify($data, $groupId);
        return true;
    }

    public function getDetailForAdmin($groupId) //($blogId)
    {
        if (empty ($groupId)) { //(empty ($blogId))
            return false;
        }
        $record = $this->dao->getDetailForAdmin($groupId); //getDetailForAdmin($blogId);
        return $record;
    }

    public function setPublishStatus($data, $groupId) //($data, $noticeId)
    {
        if (empty($data) AND (empty($groupId))) { //if (empty($data) AND (empty($noticeId)))
            return false;
        }
        $status = $this->getPublishStatus($groupId); //$this->getPublishStatus($noticeId);
        if ($status['is_active'] == 1) {
            $data['is_active'] = 0;
        } else {
            $data['is_active'] = 1;
        }
        $this->dao->modify($data, $groupId); //modify($data, $noticeId);
        return true;
    }

    public function getPublishStatus($groupId)
    {
        if (empty($groupId)) {
            return false;
        }
        return $this->dao->getPublishStatus($groupId);
    }

    public function changeBlogGroupPublishStatus($data, $blogGroupId)
    {
        if (empty($data) AND (empty($blogGroupId))) {
            return false;
        }
        $data['last_moderate_date']   = date('Y-m-d H:i:s');
        $data['blog_group_permalink'] = $blogGroupId;
        if ($data['blog_group_is_published'] == 1) {
            $data['blog_group_is_published'] = 0;
        } else {
            $data['blog_group_is_published'] = 1;
        }
        $this->dao->modify($data, $blogGroupId);
        return true;
    }
}
