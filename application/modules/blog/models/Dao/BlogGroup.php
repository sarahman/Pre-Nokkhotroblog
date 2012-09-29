<?php
/**
 * Group Type Dao Model
 *
 * @category        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_Dao_BlogGroup extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('blog_groups', 'blog_group_id');
    }


    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('blog_group_types', "blog_group_types.blog_group_type_id = {$this->_name}.blog_group_type_id")
            ->where("{$this->_name}.blog_group_is_published =?", "1")
            ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getGroupByUserName($userId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('blog_group_types', "blog_group_types.blog_group_type_id = {$this->_name}.blog_group_type_id")
            ->where("{$this->_name}.blog_group_is_published =?", "1")
            ->where("{$this->_name}.create_by =?", $userId)
            ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }


    public function remove($id = null)
    {
        if (empty ($id)) {
            return false;
        }

        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }


    public function getDetail($groupId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $groupId)
            ->where("{$this->_name}.blog_group_is_published =?", "1");

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }


    public function getDetailForAdmin($groupId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $groupId);

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }


    public function getPublishStatus($groupId)
    {
        $select = $this->select()
            ->from($this->_name, array('blog_group_is_published'))
            ->where("group_id =?", $groupId);

        return $this->returnResultAsAnArray($this->fetchRow($select));

    }

     public function getBlogGroupDetailByPermalink($permalink)
    {
        $select = $this->select()
                       ->from($this->_name)
                       ->setIntegrityCheck(false)
                       ->join('users',"{$this->_name}.create_by = users.user_id")
                       ->where("{$this->_name}.blog_group_permalink=?", $permalink)
                       ->where("{$this->_name}.blog_group_is_published=?", 1)
                       ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }



}
