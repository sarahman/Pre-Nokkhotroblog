<?php
/**
 * Discussion Dao Model
 *
 * @category        Model
 * @package         Blog
 * @author          Mohammad Zafar Iqbal <zafarmba10104014@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_Dao_Discussion extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('discussions','discussion_id');			
    }


    public function getAll()
    {

        $select = $this->select()
                       ->from($this->_name)
                       ->where("{$this->_name}.status =?", 'publish')
                        ->order(array("{$this->_primaryKey}"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
     public function getAllTrash($userId)
    {

        $select = $this->select()
                       ->from($this->_name)
                       ->where("{$this->_name}.status =?", 'trash')
                       ->where("{$this->_name}.create_by =?", $userId)  
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
    
   
	 public function getDetail($groupId)	
		{
			$select = $this->select()
				->from($this->_name)
				->where("{$this->_primaryKey} =?", $groupId);	

	 return $this->returnResultAsAnArray($this->fetchRow($select));
		}
		
		
	 public function getDetailForAdmin($discussionId)			
        {
            $select = $this->select()
	->from($this->_name)
	->where("{$this->_primaryKey} =?", $discussionId);	

	 return $this->returnResultAsAnArray($this->fetchRow($select));                                            
        }
        
        
        public function getPublishStatus($groupId)
        {
            $select = $this->select()
                           ->from($this->_name,array('is_active'))
                           ->where("group_id =?", $groupId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
        
         public function getDetailForComment($commentId)
            {
                $select = $this->select()
                    ->from($this->_name)
                    ->setIntegrityCheck(false)
                    ->join('discussion_comments',"{$this->_name}.discussion_id = discussion_comments.discussion_id")
                    ->where("{$this->_primaryKey} =?", $commentId);
                return $this->returnResultAsAnArray($this->fetchRow($select));
            }
	public function getDraftl()
         {
         $select = $this->select()
                  ->from($this->_name)
	->where("{$this->_name}.status =?",'draft'); 

         return $this->returnResultAsAnArray($this->fetchAll($select));
         }
         
         public function getTrashStatus($blogId)
        {
            $select = $this->select()
                           ->from($this->_name,array('status'))
                           ->where("discussion_id =?", $blogId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
	public function getTopDiscussion()
    {

        $select = "SELECT *, count( discussion_comment_id ) AS no
FROM  discussion_comments inner join discussions on discussions.discussion_id = discussion_comments.discussion_id
GROUP BY discussions.discussion_id
ORDER BY no DESC 
LIMIT 10";

        return $this->returnResultAsAnArray($this->getDefaultAdapter()->fetchAll(($select)));
    }

}
