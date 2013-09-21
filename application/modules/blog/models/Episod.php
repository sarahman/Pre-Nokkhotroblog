<?php
/**
 * Episod Model
 *
 * @category        Model
 * @package         Episod
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_Episod extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_Episod
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_Episod();
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
        $data['create_date'] = date('Y-m-d H:i:s');
        $authNamespace       = new Zend_Session_Namespace('userInformation');
        $data['create_by']   = $authNamespace->userData['user_id'];
        $data['post_type']   = 'episode';
        $episodeId           = $this->dao->create($data);
        return $episodeId;
    }

    public function getDetails($draftId)
    {
        if (empty ($draftId)) {
            return false;
        }

        $record = $this->dao->getDetails($draftId);
        return $record;
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

    public function getDetailForEpisode($episodeId)
    {
        if (empty ($episodeId)) {
            return false;
        }
        $record = $this->dao->getDetailEpisode($episodeId);
        return $record;
    }
    
    public function getDraft($userId)
    {
        return $this->dao->getDraft($userId);
    }

    public function setTrashStatus($data, $blogId)
    {
        if (empty($data) AND (empty($blogId))) {
            return false;
        }

        $data['last_modaretion_date'] = date('Y-m-d H:i:s');
        $data['permalink']            = $blogId;
        $status                       = $this->getTrashStatus($blogId);
        if ($status['status'] == 'trash') {
            $data['status'] = 'draft';
        } else {
            $data['status'] = 'trash';
        }
        $this->dao->modify($data, $blogId);
        return true;
    }

    public function getTrashStatus($blogId)
    {
        if (empty($blogId)) {
            return false;
        }
        return $this->dao->getTrashStatus($blogId);
    }


public function getAllTrash($userId)
    {
        return $this->dao->getAllTrash($userId);
    }
    
    public function getEpisode($episodeId)
    {
        
        $authNamespace = new Zend_Session_Namespace('userInformation');
        $data['create_by'] = $authNamespace->userData['user_id'];
        
        return $this->dao->getEpisodes($episodeId);
    }

    public function getDetaildraft($episodId)	// draft edit
    {
        if (empty ($episodId)) {		
            return false;
        }

        $record = $this->dao->getDetaildraft($episodId);	

        return $record;
    }

    public function getDetailForEpisod($episodeId)            // show detail episode
    {
        if (empty ($episodeId)) {		
            return false;
        }

        $record = $this->dao->getDetailForEpisod($episodeId);	

        return $record;
    }
    
}
