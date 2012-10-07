<?php
/**
 * Blog category Model
 *
 * @category        Model
 * @package         blog
 * @author             Mohammad Zafar Iqbal <zafar@speedplusnet.com >
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Feedback extends Speed_Model_Abstract
{

    /**
    * @var Admin_Model_Dao_Feedback
    */
    protected $dao;

    public function __construct($dao = null)
       {
           if (empty ($dao)) {
               $this->dao = new Admin_Model_Dao_Feedback();

           } else {
               $this->dao = $dao;
       }
    }



    public function getAll()
    {
        return $this->dao->getAll();
        
    }

  public function getFeedbackDetailForAdmin($userId)
    {
        if (empty ($userId)) {
            return false;
        }

        $record = $this->dao->getFeedbackDetail($userId);

        return $record;
    }
    
 public function delete($feedbackId = null)		
    		{
        if (empty($feedbackId)) {			
            return false;
        }

        return $this->dao->remove($feedbackId);		
	 }	

   
}

