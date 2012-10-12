<?php
/**
 * Blog comment Model
 * @comment        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_NoticComment extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_BlogCategory
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_NoticComment();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll($commentsId)
    {
        return $this->dao->getAll($commentsId);
    }

    public function getAllPublished()
    {
        return $this->dao->getAllPublished();
    }

    public function getAllPanding()
    {
        return $this->dao->getAllPanding();
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
        //$data['notice_id'] = $noticeId['notice_id'];
        $noticeId = $this->dao->create($data);
        return $noticeId;
    }

    public function setPublishStatus($data, $commentId)
    {
        if (empty($data) AND (empty($commentId))) {
            return false;
        }
        $status = $this->getPublishStatus($commentId);
        if ($status['is_published'] == 1) {
            $data['is_published'] = 0;
        } else {
            $data['is_published'] = 1;
        }
        $this->dao->modify($data, $commentId);
        return true;
    }

    public function getPublishStatus($commentId)
    {
        if (empty($commentId)) {
            return false;
        }
        return $this->dao->getPublishStatus($commentId);
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
}
