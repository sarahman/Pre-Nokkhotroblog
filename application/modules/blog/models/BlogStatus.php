<?php
/**
 * Blog status Model
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_BlogStatus extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_BlogStatus
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_BlogStatus();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getSelected()
    {
        return $this->dao->getSelected();
    }

    public function getstatus()
    {
        return $this->dao->getstatus();
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $categoryId = $this->dao->create($data);
        return $categoryId;
    }
}
