<?php
/**
 * Draft  Model
 *
 * @Draft        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_Model_Trash extends Speed_Model_Abstract
{

    /**
    * @var User_Model_Dao_Trash
    */
    protected $dao;

    public function __construct($dao = null)
       {
           if (empty ($dao)) {
               $this->dao = new User_Model_Dao_Trash();

           } else {
               $this->dao = $dao;
       }
    }



   public function getAll()
    	{
        return $this->dao->getAll();

    	}
        
         public function getDraftDetail($draftId)
    {
        if (empty ($draftId)) {
            return false;
        }

        $record = $this->dao->getDraftl($draftId);

        return $record;
    }
}
