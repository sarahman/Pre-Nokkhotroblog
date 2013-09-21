<?php
/**
 * Page Model
 * @category        Model
 * @package         Discussion
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Page extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_Page
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_Page();
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
        $myurl                      = new Speed_Utility_Url();
        $data['permalink']          = $myurl->getUrl($data['page_name']);
        $data['last_moderate_date'] = date('Y-m-d H:i:s');
        $authNamespace              = new Zend_Session_Namespace('adminInformation');
        $data['last_moderate_by']   = $authNamespace->adminData['admin_id'];
        $postId                     = $this->dao->create($data);
        return $postId;
    }

    public function  getDetailByPagePermalink($permalink)
    {
        if (empty($permalink)) {
            return false;
        }
        $record = $this->dao->getDetailByPagePermalink($permalink);
        return $record;
    }

    public function modify($data = array(), $pageId = null)
    {
        if (empty($data) || empty($pageId)) {
            return false;
        }
        $data['update_date'] = date('Y-m-d H:i:s');
        $this->dao->modify($data, $pageId);
        return true;
    }

    public function getAllTrash()
    {
        return $this->dao->getAllTrash();
    }

    public function getPublish()
    {
        return $this->dao->getPublish();
    }

    public function setPendingStatus($data, $pageId)
    {
        if (empty($data) AND (empty($pageId))) {
            return false;
        }
        $data['last_moderate_date'] = date('Y-m-d H:i:s');
        $data['permalink']          = $pageId;
        $status                     = $this->getPendingStatus($pageId);
        if ($status['status'] == 'publish') {
            $data['status'] = 'pending';
        } else {
            $data['status'] = 'publish';
        }
        $this->dao->modify($data, $pageId);
        return true;
    }

    public function getPendingStatus($pageId)
    {
        if (empty($pageId)) {
            return false;
        }
        return $this->dao->getPendingStatus($pageId);
    }

    public function setTrashStatus($data, $pageId)
    {
        if (empty($data) AND (empty($pageId))) {
            return false;
        }
        $data['last_moderate_date'] = date('Y-m-d H:i:s');
        $data['permalink']          = $pageId;
        $status                     = $this->getTrashStatus($pageId);
        if ($status['status'] == 'admin-trash') {
            $data['status'] = 'pending';
        } else {
            $data['status'] = 'admin-trash';
        }
        $this->dao->modify($data, $pageId);
        return true;
    }

    public function getTrashStatus($pageId)
    {
        if (empty($pageId)) {
            return false;
        }
        return $this->dao->getTrashStatus($pageId);
    }
}
