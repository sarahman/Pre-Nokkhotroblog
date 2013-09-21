 <?php
/**
 * EpisodeComment Dao Model
 *
 * @category        Model
 * @package         Blog
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Dao_EpisodComment extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('episode_comments','episode_comment_id');			
    }

 public function getDetailByComment($commentId)			
        {
            $select = $this->select()
				->from($this->_name)
                                ->setIntegrityCheck(false)
                                ->join('users',"{$this->_name}.create_by = users.user_id")
				->where("episode_comments.blog_id=?", $commentId)	
				->order(array("{$this->_primaryKey} DESC"));
	 return $this->returnResultAsAnArray($this->fetchAll($select));
        }
    
    //this function is used for admin to show all pending comments
    public function getPendingComment()     
    {
        $select = $this->select()
                       ->from($this->_name)
                       ->where("status =?", 'pending')
                        ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
    
    //this function is used for admin to show all publish comments
    public function getPublishComment() 
    {
        $select = $this->select()
                       ->from($this->_name)
                       ->where("status =?", 'publish')
                       // ->where("blog_id =?", $commentId)
                        ->order(array("{$this->_primaryKey} DESC"));

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
    
    //this function is used for admin to show comment detail
    public function getDetailForAdmin($episodecommentId)			
    {
            $select = $this->select()
	->from($this->_name)
	->where("{$this->_primaryKey} =?", $episodecommentId);	

	 return $this->returnResultAsAnArray($this->fetchRow($select));
    }
    
    //this function is used for publish/pending comment
    public function getPublishStatus($commentId)
        {
            $select = $this->select()
                           ->from($this->_name,array('status'))
                           ->where("episode_comment_id =?", $commentId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }

}

