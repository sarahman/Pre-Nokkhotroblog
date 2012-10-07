<?php
/**
 * Discussion Model
 *
 * @category        Model
 * @package         Discussion
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_DiscussionComment extends Speed_Model_Abstract
{

    /**
    * @var Admin_Model_Dao_DiscussionComment
    */
    protected $dao;

    public function __construct($dao = null)
       {
           if (empty ($dao)) {
               $this->dao = new Admin_Model_Dao_DiscussionComment();

           } else {
               $this->dao = $dao;
       }
    }



	public function getAll()
	{
	return $this->dao->getAll();

	}


	public function delete($discussionId = null)	
    		{
        if (empty($discussionId)) {	
            return false;
        }

        return $this->dao->remove($discussionId);
   }


    
    public function getDetail($discussionId)          	
    {
        if (empty ($discussionId)) {                  	
            return false;
        }

        $record = $this->dao->getDetail($discussionId);     	

        return $record;
    }
        
    public function modify($data = array(), $discussionId = null)	
    {
        if (empty($data) || empty($discussionId)) {		
            return false;
        }

        $data['update_date']   = date('Y-m-d H:i:s');
       
        $this->dao->modify($data, $discussionId);
        return true;
    }
    
    public function getDetailForAdmin($discussioncommentId)			
    {
        if (empty ($discussioncommentId)) {				
            return false;
        }

        $record = $this->dao->getDetailForAdmin($discussioncommentId);			

        return $record;
    }
    
   
     public function setPublishStatus($data, $discussionId)		
    {
        if (empty($data) AND (empty($discussionId))) {		
            return false;
        }


        $status = $this->getPublishStatus($discussionId);		

        if ($status['is_published'] == 1) { 

            $data['is_published'] = 0;
        } else {
            $data['is_published'] = 1;
        }
         $data['update_date']   = date('Y-m-d H:i:s');
        $this->dao->modify($data, $discussionId);		

        return true;
    }

  public function getPublishStatus($discussionId)
    {
        if (empty($discussionId)) {
            return false;
        }

        return $this->dao->getPublishStatus($discussionId);
    }


    public function getCommentByDiscussion($commentsId)
    {
        if (empty($commentsId)) {
            return false;
        }

        return $this->dao->getCommentByDiscussion($commentsId);
    }

     public function setTrashStatus($data, $discussionId)		
    {
        if (empty($data) AND (empty($discussionId))) {		
            return false;
        }


        $status = $this->getTrashStatus($discussionId);		

        if ($status['status'] == 1) { 

            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }
     
        $this->dao->modify($data, $discussionId);		

        return true;
    }

  public function getTrashStatus($discussionId)
    {
        if (empty($discussionId)) {
            return false;
        }

        return $this->dao->getTrashStatus($discussionId);
    }


}
