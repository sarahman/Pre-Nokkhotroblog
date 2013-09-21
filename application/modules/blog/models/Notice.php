<?php
/**
 * Notice Model
 * @Notice        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_Notice extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_Notice
     */
    protected $dao;

    public function __construct(Speed_Model_Dao_Abstract $dao = null)
    {
        if ($dao) {
            $this->setDao($dao);
        } else {
            $this->setDao(new Blog_Model_Dao_Notice());
        }
    }

    public function getNoticePost()
    {
        return $this->dao->getNoticePost();
    }
}
