<?php
/**
 * Sticky Controller
 * @Group Type   Controller
 * @package     Blog
 * Date Sep 24 2012
 * @author      Mohammad Zafar iqbal <zafar@speedplusnet.com>
 */
class Blog_Model_Dao_Sticky extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('blogs', 'blog_id');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("sticky_on_home_page =?", 1)
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getDetailForAdmin($stickyId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("{$this->_primaryKey} =?", $stickyId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
}
