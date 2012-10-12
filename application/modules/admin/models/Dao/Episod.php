<?php
/**
 * Discussion Dao Model
 * @category        Model
 * @package         Admin
 * @author          Mohammad Zafar Iqbal <zafarmba10104014@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Dao_Episod extends Speed_Model_Dao_Abstract
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
            ->setIntegrityCheck(false)
            ->join('episode_name', "{$this->_name}.episode_id = episode_name.episode_id")
            ->where("post_type ='episode'")
            ->where("{$this->_name}.status =?", 'pending')
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

    public function getDetail($discussionId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $discussionId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getDetailForEpisod($episodId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $episodId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getPublishStatus($episodId)
    {
        $select = $this->select()
            ->from($this->_name, array('status'))
            ->where("blog_id =?", $episodId);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
}
