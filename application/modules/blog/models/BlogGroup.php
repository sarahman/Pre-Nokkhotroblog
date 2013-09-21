<?php
/**
 * Group Type Model
 * @category        Model
 * @package         Group type
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_BlogGroup extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_BlogGroup
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_BlogGroup();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getGroupByUserName($userId)
    {
        return $this->dao->getGroupByUserName($userId);
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $permalink                       = new Speed_Utility_Url();
        $data['blog_group_permalink']    = $permalink->getUrl($data['blog_group']);
        $data['create_date']             = date('Y-m-d H:i:s');
        $authNamespace                   = new Zend_Session_Namespace('userInformation');
        $data['create_by']               = $authNamespace->userData['user_id'];
        $data['blog_group_type_id']      = "2";
        $data['blog_group_is_published'] = "0";
        $postId                          = $this->dao->create($data);
        return $postId;
    }

    public function modify($data = array(), $groupId = null)
    {
        if (empty($data) || empty($groupId)) {
            return false;
        }
        $data['update_date']             = date('Y-m-d H:i:s');
        $authNamespace                   = new Zend_Session_Namespace('userInformation');
        $data['update_by']               = $authNamespace->userData['user_id'];
        $data['blog_group_is_published'] = 0;
        $this->dao->modify($data, $groupId);
        return true;
    }

    public function getDetailForAdmin($groupId)
    {
        if (empty ($groupId)) {
            return false;
        }
        $record = $this->dao->getDetailForAdmin($groupId);
        return $record;
    }

    public function setPublishStatus($data, $groupId)
    {
        if (empty($data) AND (empty($groupId))) {
            return false;
        }
        $status = $this->getPublishStatus($groupId);
        if ($status['is_active'] == 1) {
            $data['is_active'] = 0;
        } else {
            $data['is_active'] = 1;
        }
        $this->dao->modify($data, $groupId);
        return true;
    }

    public function getPublishStatus($groupId)
    {
        if (empty($groupId)) {
            return false;
        }
        return $this->dao->getPublishStatus($groupId);
    }

    public function getBlogGroupDetailByPermalink($permalink)
    {
        if (empty($permalink)) {
            return false;
        }
        return $this->dao->getBlogGroupDetailByPermalink($permalink);
    }
}
