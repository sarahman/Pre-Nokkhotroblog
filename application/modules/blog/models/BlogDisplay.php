<?php
/**
 * Blog category Model
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_BlogDisplay extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_BlogDisplay
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_BlogDisplay();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
        return $result;
    }
}
