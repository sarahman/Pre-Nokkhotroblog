<?php
/**
 * Episod Model
 * @category        Model
 * @package         Episod
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_EpisodName extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_EpisodName
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_EpisodName();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $authNamespace     = new Zend_Session_Namespace('userInformation');
        $data['create_by'] = $authNamespace->userData['user_id'];
        $data['post_type'] = 'episode';
        $episodeId         = $this->dao->create($data);
        return $episodeId;
    }

    public function getDetailForEpisode($userId)
    {
        if (empty ($userId)) {
            return false;
        }
        $record = $this->dao->getDetailForEpisode($userId);
        return $record;
    }

    public function getEpisodesByUser($userId)
    {
        if (empty($userId)) {
            return false;
        }
        return $this->dao->getEpisodesByUser($userId);
    }
}
