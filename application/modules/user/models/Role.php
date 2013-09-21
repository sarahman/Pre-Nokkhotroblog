<?php
/**
 * Role Model
 * @category    Model
 * @package     User
 * @author      Eftakhairul Islam <eftakhairul@gmail.com>
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://rightbrainsolution.com)
 */
class User_Model_Role extends Speed_Model_Abstract
{
    /**
     * @var User_Model_Dao_Role
     */
    protected $dao;

    public function __construct(Speed_Model_Dao_Abstract $dao = null)
    {
        if ($dao) {
            $this->setDao($dao);
        } else {
            $this->setDao(new User_Model_Dao_Role());
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function save(array $data)
    {
        return $this->dao->create($data);
    }
}