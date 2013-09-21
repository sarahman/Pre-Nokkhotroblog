<?php
/**
 * Blog status Dao Model
 * @category        Model
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_Dao_BlogStatus extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('status', 'status_id');
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->_name);
        return $this->returnResultAsAnArray($this->fetchAll($select));
    }

    public function getSelected()
    {
        $status       = $this->getAll();
        $blogStatus[] = $status[2];
        $blogStatus[] = $status[1];
        return $blogStatus;
    }

    public function getstatus()
    {
        $status       = $this->getAll();
        $blogStatus[] = $status[1];
        $blogStatus[] = $status[2];
        $blogStatus[] = $status[3];
        return $blogStatus;
    }

    public function remove($id = null)
    {
        if (empty ($id)) {
            return false;
        }
        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }
}
