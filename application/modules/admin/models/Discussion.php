<?php
/**
 * Discussion Model
 *
 * @category        Model
 * @package         Discussion
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Discussion extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_Discussion
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_Discussion();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getAllDiscussionTrash()
    {
        return $this->dao->getAllDiscussionTrash();
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

    public function modify($data = array(), $discussionId = null)
    {
        if (empty($data) || empty($discussionId)) {
            return false;
        }
        $data['update_date'] = date('Y-m-d H:i:s');
        $this->dao->modify($data, $discussionId);
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

    public function setPublishStatus($data, $discussionId)
    {
        if (empty($data) AND (empty($discussionId))) {
            return false;
        }
        $status = $this->getPublishStatus($discussionId);
        if ($status['status'] == 'publish') {
            $data['status'] = 'pending';
        } else {
            $data['status'] = 'publish';
        }
        $this->dao->modify($data, $discussionId);
        return true;
    }

    public function getPublishStatus($discussionId)
    {
        if (empty($discussionId)) {
            return false;
        }
        return $this->dao->getPublishStatus($discussionId);
    }

public function getAllPublishDiscussion()
	{
	return $this->dao->getAllPublishDiscussion();

	}
public function getAllPandingDiscussion()
	{
	return $this->dao->getAllPandingDiscussion();

	}

 public function setTrashStatus($data, $discussionId)		
    {
        if (empty($data) AND (empty($discussionId))) {		
            return false;
        }


        $status = $this->getTrashStatus($discussionId);		

        if ($status['status'] == 'pending') { 

            $data['status'] = 'admin-trash';
        } else {
            $data['status'] = 'pending';
        }
     
        $this->dao->modify($data, $discussionId);		

        return true;
    }

  public function getTrashStatus($discussionId)
    {
        if (empty($discussionId)) {
            return false;
        }

        return $this->dao->getTrashStatus($discussionId);
    }


}
