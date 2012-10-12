<?php
/**
 * Blog category Dao Model
 * @category        Model
 * @package         Blog
 * @author          Mohammad Zafar Iqbal
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_Dao_NovelName extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('novel_name', 'novel_name_id');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("{$this->_name}.novel_name_is_published =?", 1)
            ->order(array("{$this->_primaryKey} DESC"));
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function myNovel($userId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("{$this->_name}.create_by =?", $userId)
            ->where("{$this->_name}.novel_name_is_published =?", 1)
            ->order($this->_primaryKey, 'DESC');
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getDetailByNovelPermalink($novelName)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_name}.novel_name_permalink =?", $novelName);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function remove($id = null)
    {
        if (empty ($id)) {
            return false;
        }
        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }

    public function getNovelDetail($novelId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where('novel_name_id=?', $novelId);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getDetail($nId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $nId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getDetailForNovel($userId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("novel_name_id =?", $userId);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
}
