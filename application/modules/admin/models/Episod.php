<?php
/**
 * Episod Model
 * @category        Model
 * @package         Episod
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Episod extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_Episod
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_Episod();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function modify($data = array(), $episodId = null)
    {
        if (empty($data) || empty($episodId)) {
            return false;
        }
        $data['update_date'] = date('Y-m-d H:i:s');
        $this->dao->modify($data, $episodId);
        return true;
    }

    public function getDetailForEpisod($episodId)
    {
        if (empty ($episodId)) {
            return false;
        }
        $record = $this->dao->getDetailForEpisod($episodId);
        return $record;
    }

    public function setPublishStatus($data, $episodId)
    {
        if (empty($data) AND (empty($episodId))) {
            return false;
        }
        $status = $this->getPublishStatus($episodId);
        if ($status['status'] == 'publish') {
            $data['status'] = 'pending';
        } else {
            $data['status'] = 'publish';
        }
        $this->dao->modify($data, $episodId);
        return true;
    }

    public function getPublishStatus($episodId)
    {
        if (empty($episodId)) {
            return false;
        }
        return $this->dao->getPublishStatus($episodId);
    }
}
