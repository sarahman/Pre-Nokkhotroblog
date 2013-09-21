<?php
/**
 * Episod Dao Model
 *
 * @category        Model
 * @package         Blog
 * @author          Mohammad Zafar Iqbal <zafarmba10104014@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_Dao_Episod extends Speed_Model_Dao_Abstract
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
            ->where("status =?", 'publish')
            ->where("post_type ='episode'")
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

    public function getDetail($episodeId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('episode_name', "episode_name.episode_id = {$this->_name}.episode_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("blogs.is_published =?", 1)
            ->where("{$this->_primaryKey} =?", $episodeId);

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getDetails($draftId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_primaryKey} =?", $draftId);

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getDetailEpisode($episodeId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('episode_name', "episode_name.episode_id = {$this->_name}.episode_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("{$this->_name}.status =?", 'publish')
            ->where("{$this->_name}.post_type =?", 'episode')
            ->where("blogs.episode_id =?", $episodeId);
     
        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getDraft($userId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_name}.post_type =?", 'episode')
            ->where("{$this->_name}.status =?", 'draft')
            ->where("{$this->_name}.create_by =?", $userId);

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
    public function getTrashStatus($blogId)
    {
        $select = $this->select()
            ->from($this->_name, array('status'))
            ->where("blog_id =?", $blogId);

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
    public function getAllTrash($userId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("{$this->_name}.post_type =?", 'episode')
            ->where("{$this->_name}.status =?", 'trash')
            ->where("{$this->_name}.create_by =?", $userId)                 // this line is for add session
            ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
   public function getEpisodes($episodeId)
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('episode_name', "{$this->_name}.episode_id = episode_name.episode_id")               //  {$this->_name}  episode_name
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("status =?", 'publish')
            ->where("post_type ='episode'")
            ->where("blogs.episode_id =?", $episodeId)
            ->order(array("{$this->_primaryKey} ASC"));
       
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
    public function getDetaildraft($episodeId)          //draft edit
    {
        $select = $this->select()
            ->from($this->_name)
            ->setIntegrityCheck(false)
            ->join('episode_name', "episode_name.episode_id = {$this->_name}.episode_id")
            ->join('users', "{$this->_name}.create_by = users.user_id")
            ->where("blogs.status =?", 'draft')
            ->where("{$this->_primaryKey} =?", $episodeId);

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }

    public function getDetailForEpisod($episodeId)            // show detail episode
    {
        $select = $this->select()
            ->from($this->_name)
                ->setIntegrityCheck(false)
           // ->join('episode_name', "{$this->_name}.episode_id = episode_name.episode_id")      
            ->join('users', "{$this->_name}.create_by = users.user_id")
             ->where("status =?", 'publish')
            ->where("{$this->_primaryKey} =?", $episodeId);

        return $this->returnResultAsAnArray($this->fetchRow($select));
    }
}
