<?php
/**
 * Blog category Dao Model
 *
 * @category        Model
 * @package         Blog
 * @author          Mohammad Zafar Iqbal <zafar@speedplusnet.com >
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_Dao_Feedback extends Speed_Model_Dao_Abstract
{
    public function __construct()
    	{
        parent::__construct();
        $this->loadTable('feedbacks','feedback_id ');
	
   	 }

	public function remove($id = null)
    	{
			if (empty ($id)) 
			{
				return false;
			}

			return parent::delete("{$this->_primaryKey} = '{$id}'");
		}
}

