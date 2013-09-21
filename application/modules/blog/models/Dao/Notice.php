<?php
/**
 * Blog Dao Model
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_Dao_Notice extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('notices', 'notice_id');
    }

    public function getNoticePost()
    {
        $select = $this->select()
            ->from($this->_name)
            ->where("notices.make_active =?", 1)
            ->order(array("{$this->_primaryKey} DESC"))
            ->limit(1);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }
}
