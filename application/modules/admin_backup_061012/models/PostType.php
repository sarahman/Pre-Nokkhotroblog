<?php
/**
 * Post Type Model
 *
 * @category        Model
 * @package         post type
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_PostType extends Speed_Model_Abstract
{

    /**
    * @var Admin_Model_Dao_PostType
    */
    protected $dao;

    public function __construct($dao = null)
       {
           if (empty ($dao)) {
               $this->dao = new Admin_Model_Dao_PostType();

           } else {
               $this->dao = $dao;
       }
    }



        public function getAll()
    	{
        return $this->dao->getAll();

    	}


	public function delete($postId = null)		
    		{
        if (empty($postId)) {			
            return false;
        }

        return $this->dao->remove($postId);		
	 }

	public function save($data)
    		{
        if (empty($data)) {
            return false;
        }

        $postId = $this->dao->create($data);		
        return $postId;				
        }
         public function getDetailForAdmin($postId)		
    {
        if (empty ($postId)) {		
            return false;
        }

        $record = $this->dao->getDetailForAdmin($postId);	

        return $record;
    }
        public function getDetail($postId)		
    {
        if (empty ($postId)) {			
            return false;
        }

        $record = $this->dao->getDetail($postId);	

        return $record;
    }
        
 
  
            public function modify($data = array(), $postId = null)	
    {
        if (empty($data) || empty($postId)) {				
            return false;
        }

        $this->dao->modify($data, $postId);		
        return true;
    }

	

}
