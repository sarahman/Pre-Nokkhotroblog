<?php
/**
 * Post Type Dao Model
 *
 * @category        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_Dao_PostType extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('post_types','post_type_id');
    }


    public function getAll()
    {

        $select = $this->select()
                       ->from($this->_name);

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }


	
	 public function remove($id = null)
    		{
        if (empty ($id)) {
            return false;
        }

        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }
    
    
       public function getDetail($postId)			
        {
            $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_primaryKey} =?", $postId);		

            return $this->returnResultAsAnArray($this->fetchRow($select));
        }

        public function getDetailForAdmin($postId)		
            {
                $select = $this->select()
                    ->from($this->_name)
                    ->setIntegrityCheck(false)
                    ->where("{$this->_primaryKey} =?", $postId);		

                return $this->returnResultAsAnArray($this->fetchRow($select));
            }



 	

}
