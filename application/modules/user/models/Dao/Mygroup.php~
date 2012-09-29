<?php
/**
 * notice Dao Model
 *
 * @notice        Model
 * @package         notice
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_Model_Dao_Mygroup extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('my_groups','my_group_id');
    }


    public function getAll()
    {

        $select = $this->select()
                       ->from($this->_name);
				
			
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }


    public function getDetailForGroup($detailId)
            {
                $select = $this->select()
                    ->from($this->_name)
                    ->where("{$this->_primaryKey} =?", $detailId);

                return $this->returnResultAsAnArray($this->fetchRow($select));
            }


        public function getPublishStatus($detailId)
        {
            $select = $this->select()
                           ->from($this->_name,array('is_active'))
                           ->where("my_group_id =?", $detailId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
	


     

}
