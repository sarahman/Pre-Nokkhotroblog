<?php
/**
 * Discussion Model
 *
 * @category        Model
 * @package         Discussion
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_Discussion extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_Discussion
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_Discussion();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }
    
    public function getAllTrash($userId)
    {
        return $this->dao->getAllTrash($userId);
    }

    public function delete($discussionId = null)
    {
        if (empty($discussionId)) {
            return false;
        }

        return $this->dao->remove($discussionId);
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $data['create_date'] = date('Y-m-d H:i:s');
        $authNamespace       = new Zend_Session_Namespace('userInformation');
        $data['create_by']   = $authNamespace->userData['user_id'];
        $postId              = $this->dao->create($data);
        return $postId;
    }

    public function modify($data = array(), $postId = null)
    {
        if (empty($data) || empty($postId)) {
            return false;
        }
        $data['update_date'] = date('Y-m-d H:i:s');
        $this->dao->modify($data, $postId);
        return true;
    }

    public function getDetailForAdmin($discussionId)
    {
        if (empty ($discussionId)) {
            return false;
        }
        $record = $this->dao->getDetailForAdmin($discussionId);
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

    public function getDetailForComment($commentId)
    {
        if (empty ($commentId)) {
            return false;
        }

        $record = $this->dao->getDetailForComment($commentId);
        return $record;
    }

    public function getDraftl()
    {
        return $this->dao->getDraftl();
    }

    public function setTrashStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }
        $data['last_modaretion_date'] = date('Y-m-d H:i:s');
        $data['permalink']            = $blogId;
        $status                       = $this->getTrashStatus($blogId);
        if ($status['status'] == 'trash') {
            $data['status'] = 'draft';
        } else {
            $data['status'] = 'trash';
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

    public function getTopDiscussion()
    {
        return $this->dao->getTopDiscussion();
    }
}
