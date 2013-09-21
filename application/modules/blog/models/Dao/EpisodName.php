<?php
/**
 * Episod Dao Model
 * @category        Model
 * @package         Blog
 * @author          Mohammad Zafar Iqbal <zafarmba10104014@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_Dao_EpisodName extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('episode_name', 'episode_id');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function remove($id = null)
    {
        if (empty ($id)) {
            return false;
        }
        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }

    public function getDetail($episodId)
    {
        $select = $this->select()
            ->from($this->_name);
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getDetailForEpisode($userId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("episode_id=?", $userId);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getEpisodesByUser($userId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("create_by=?", $userId);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
}
