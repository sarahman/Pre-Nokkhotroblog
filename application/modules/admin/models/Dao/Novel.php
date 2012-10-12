<?php
/**
 * Blog category Dao Model
 * @category        Model
 * @package         Blog
 * @author          Mohammad Zafar Iqbal
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_Dao_Novel extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('novels', 'novel_id ');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getNovelDetail($novelId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('novel_name', "novel_name.novel_name_id = {$this->_name}.novel_name_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("{$this->_name}.novel_name_id=?", $novelId)
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getSingleNovelEntry($permalink)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('novel_name', "novel_name.novel_name_id = {$this->_name}.novel_name_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("{$this->_name}.novel_post_permalink=?", $permalink)
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getDetail($postId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('novel_name', "novel_name.novel_name_id = {$this->_name}.novel_name_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("{$this->_primaryKey} =?", $postId)
            ->order(array("{$this->_primaryKey} DESC"));
        ;
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function remove($id = null)
    {
        if (empty ($id)) {
            return false;
        }
        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }

    public function getSelectStatus($userId)
    {
        $select = $this->select()
            ->from($this->_name, array('user_status'))
            ->where("admin_id =?", $userId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
}

