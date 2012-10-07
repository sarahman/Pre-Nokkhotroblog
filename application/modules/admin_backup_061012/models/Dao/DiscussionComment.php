<?php
/**
 * Discussion Dao Model
 *
 * @category        Model
 * @package         Admin
 * @author          Mohammad Zafar Iqbal <zafarmba10104014@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Dao_DiscussionComment extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('discussion_comments','discussion_comment_id');			
    }


    public function getAll()
    {

        $select = $this->select()
                       ->from($this->_name)
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
		
		
	 public function getDetailForAdmin($discussioncommentId)			
        {
            $select = $this->select()
				->from($this->_name)
				->where("{$this->_primaryKey} =?", $discussioncommentId);	

	 return $this->returnResultAsAnArray($this->fetchRow($select));
        }
        
        public function getPublishStatus($discussionId)
        {
            $select = $this->select()
                           ->from($this->_name,array('is_published'))
                           ->where("discussion_comment_id =?", $discussionId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
	

}
