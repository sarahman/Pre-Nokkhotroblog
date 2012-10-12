<?php
/**
 * Draft  Model
 * @Draft        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_Draft extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_Draft
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_Draft();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getDraftDetail($draftId)
    {
        if (empty ($draftId)) {
            return false;
        }
        $record = $this->dao->getDraftl($draftId);
        return $record;
    }

    public function modify($data = array(), $draftId = null)
    {
        if (empty($data) || empty($draftId)) {
            return false;
        }
        $data['update_date'] = date('Y-m-d H:i:s');
        $authNamespace       = new Zend_Session_Namespace('userInformation');
        $data['update_by']   = $authNamespace->userData['user_id'];
        $this->dao->modify($data, $draftId);
        return true;
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
}
