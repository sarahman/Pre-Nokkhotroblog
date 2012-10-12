<?php
/**
 * Blog category Model
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_BlogComment extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_BlogCategory
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_BlogComment();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

// Zafar Sep 22
    public function getAllCommentTrash()
    {
        return $this->dao->getAllCommentTrash();
    }

    public function getDetailForAdmin($blogId)
    {
        if (empty ($blogId)) {
            return false;
        }
        $record = $this->dao->getDetailForAdmin($blogId);
        return $record;
    }

    /*public function setPublishStatus($blogId)
    {
        if (empty($blogId)) {
                    return false;
                }

        $display = $this->getPublishStatus($blogId);

        if ($display['is_published'] == 1) {

            $data['is_published'] = 0;
        } else {
            $display['is_published'] = 1;
        }

        $this->dao->modify($blogId);

        return true;
    }

    public function getPublishStatus($blogId)
    {
        if (empty($blogId)) {
            return false;
        }

        return $this->dao->getPublishStatus($blogId);
    }*/
    public function setPublishStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }
        // $data['last_modaretion_date'] = date('Y-m-d H:i:s');
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

    /*public function modify($blogId = null)
    {
        if (empty($blogId)) {
            return false;
        }

        $data['is_published'] = 0;

        $this->dao->modify($blogId);
        return true;
    }*/

    public function modify($data = array(), $commentId = null)
    {
        if (empty($data) || empty($commentId)) {
            return false;
        }
        $this->dao->modify($data, $commentId);
        return true;
    }

    // For Trash Sep22 MOHAMMAD ZAFAR IQBAL
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
}
