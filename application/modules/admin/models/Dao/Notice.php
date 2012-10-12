<?php
/**
 * notice Dao Model
 * @notice        Model
 * @package         notice
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_Dao_Notice extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('notices', 'notice_id');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getDetailForAdmin($noticeId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $noticeId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getDetail($noticeId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $noticeId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getPublishStatus($noticeId)
    {
        $select = $this->select()
            ->from($this->_name, array('is_valid'))
            ->where("notice_id =?", $noticeId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getAllNotic()
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("is_valid =?", 1);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getActiveStatus($noticeId)
    {
        $select = $this->select()
            ->from($this->_name, array('make_active'))
            ->where("notice_id =?", $noticeId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
}
