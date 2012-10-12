<?php


/**
 * User Model
 * @category    Model
 * @package     Library
 * @author      Eftakhairul Islam <eftakhairul@gmail.com>
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://www.rightbrainsolution.com)
 */
class Speed_Model_Photo extends Speed_Model_Abstract
{
    /**
     * @var Speed_Model_Dao_Photo
     */
    protected $dao;
    protected $salt = "Speed-Key";

    public function __construct(Speed_Model_Dao_Abstract $dao = null)
    {
        if ($dao) {
            $this->setDao($dao);
        } else {
            $this->setDao(new Speed_Model_Dao_Photo());
        }
    }

    public function validateUser($data = array())
    {
        if (empty($data)) {
            return false;
        }
        (empty($data['password'])) || ($data['password'] = $this->applyHashing($data['password'], $this->salt));
        return $this->dao->validateUser($data);
    }

    public function save($data = array())
    {
        if (empty($data)) {
            return false;
        }
        $authNamespace   = new Zend_Session_Namespace('userInformation');
        $data['user_id'] = $authNamespace->userData['user_id'];
        return $this->dao->create($data);
    }
}
