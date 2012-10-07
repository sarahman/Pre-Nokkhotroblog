<?php
/**
 * Notice Model
 *
 * @Notice          Model
 * @package         admin
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_Notice extends Speed_Model_Abstract
{

    /**
     * @var Admin_Model_Dao_Notice
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_Notice();

        } else {
            $this->dao = $dao;
        }
    }


    public function getAll()
    {
        return $this->dao->getAll();

    }

    public function getDetailForAdmin($noticeId)
    {
        if (empty ($noticeId)) {
            return false;
        }

        $record = $this->dao->getDetailForAdmin($noticeId);

        return $record;
    }


    public function save($data = array())
    {
        if (empty($data)) {
            return false;
        }

        $data['create_date'] = date('Y-m-d H:i:s');
        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $data['create_by'] = $authNamespace->adminData['admin_id'];
        $noticeId = $this->dao->create($data);
        return $noticeId;
    }


    public function delete($noticeId = null)
    {
        if (empty($noticeId)) {
            return false;
        }

        return $this->dao->remove($noticeId);
    }


    public function getDetail($noticeId)
    {
        if (empty ($noticeId)) {
            return false;
        }

        $record = $this->dao->getDetail($noticeId);

        return $record;
    }


    public function modify($data = array(), $noticeId = null)
    {
        if (empty($data) || empty($noticeId)) {
            return false;
        }
        $data['update_date'] = date('Y-m-d H:i:s');
        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $data['update_by'] = $authNamespace->adminData['admin_id'];
        $permalink = new Speed_Utility_Url();
        $data['permalink'] = $permalink->getUrl($data['title']);

        $this->dao->modify($data, $noticeId);
        return true;
    }


    public function setPublishStatus($data, $noticeId)
    {
        if (empty($data) AND (empty($noticeId))) {
            return false;
        }


        $status = $this->getPublishStatus($noticeId);

        if ($status['is_valid'] == 1) {

            $data['is_valid'] = 0;
        } else {
            $data['is_valid'] = 1;
        }

        $this->dao->modify($data, $noticeId);

        return true;
    }

    public function getPublishStatus($noticeId)
    {
        if (empty($noticeId)) {
            return false;
        }

        return $this->dao->getPublishStatus($noticeId);
    }
public function getAllNotic()
    {
        return $this->dao->getAllNotic();

    }


    public function setActiveStatus($data, $noticeId)
    {
        if (empty($data) AND (empty($noticeId))) {
            return false;
        }


        $status = $this->getActiveStatus($noticeId);

        if ($status['make_active'] == 1) {

            $data['make_active'] = 0;
        } else {
            $data['make_active'] = 1;
        }

        $this->dao->modify($data, $noticeId);

        return true;
    }

public function getActiveStatus($noticeId)
    {
        if (empty($noticeId)) {
            return false;
        }

        return $this->dao->getActiveStatus($noticeId);
    }

public function getActiveNotic()
    {

        return $this->dao->getActiveNotic();
    }
public function getArcriveNotic()
    {

        return $this->dao->getArcriveNotic();
    }

   public function setUnActiveStatus($data, $noticeId)
    {
        if (empty($data) AND (empty($noticeId))) {
            return false;
        }


        $status = $this->getUnActiveStatus($noticeId);

        if ($status['make_active'] == 1) {

            $data['make_active'] = 2;
        } else {
            $data['make_active'] = 1;
        }

        $this->dao->modify($data, $noticeId);

        return true;
    }

public function getUnActiveStatus($noticeId)
    {
        if (empty($noticeId)) {
            return false;
        }

        return $this->dao->getUnActiveStatus($noticeId);
    }
   public function setTrashStatus($data, $noticeId)
    {
        if (empty($data) AND (empty($noticeId))) {
            return false;
        }

        $status = $this->getTrashStatus($noticeId);

        if ($status['status'] == 1) {

            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }
        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $data['update_by'] = $authNamespace->adminData['admin_id'];

        $this->dao->modify($data, $noticeId);

        return true;
    }

public function getTrashStatus($noticeId)
    {
        if (empty($noticeId)) {
            return false;
        }

        return $this->dao->getTrashStatus($noticeId);
    }

public function getPandingNotic()
    {

        return $this->dao->getPandingNotic();
    }
public function getTrashNotic()
    {

        return $this->dao->getTrashNotic();
    }



}
