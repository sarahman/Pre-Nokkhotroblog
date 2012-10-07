<?php
/**
 * EpisodeComment Model
 *
 * @category        Model
 * @package         blog
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_EpisodComment extends Speed_Model_Abstract
{

    /**
    * @var Blog_Model_Dao_DiscussionComment
    */
    protected $dao;

    public function __construct($dao = null)
       {
           if (empty ($dao)) {
               $this->dao = new Admin_Model_Dao_EpisodComment();

           } else {
               $this->dao = $dao;
       }
    }


    public function getDetailByComment($commentId)			
    {
        if (empty ($commentId)) {				
            return false;
        }

        $record = $this->dao->getDetailByComment($commentId);			

        return $record;
    }
	

    
    //this function is used for admin to show all pending comments    
    public function getPendingComment()  
    {
        return $this->dao->getPendingComment(); 
    }
        
    //this function is used for admin to show all publish comments    
    public function getPublishComment()    
    {
        return $this->dao->getPublishComment();   
    }
    
    //this function is used for admin to show comment detail
    public function getDetailForAdmin($episodecommentId)			
    {
        if (empty ($episodecommentId)) {				
            return false;
        }

        $record = $this->dao->getDetailForAdmin($episodecommentId);			

        return $record;
    }
    
    //this function is used for publish/pending comment
    public function setPublishStatus($data, $commentId)		
    {
        if (empty($data) AND (empty($commentId))) {		
            return false;
        }

        $status = $this->getPublishStatus($commentId);		

        if ($status['status'] == 'publish') {

            $data['status'] ='pending';
        } else {
            $data['status'] = 'publish';
        }

        $this->dao->modify($data, $commentId);		

        return true;
    }

    public function getPublishStatus($commentId)
    {
        if (empty($commentId)) {
            return false;
        }

        return $this->dao->getPublishStatus($commentId);
    }
    	
}
