<?php
/**
 * Created by JetBrains PhpStorm.
 * User: salayhin
 * Date: 6/19/12
 * Time: 1:47 AM
 * To change this template use File | Settings | File Templates.
 */
class Speed_Model_AdminUser extends Speed_Model_Abstract
{
    /**
     * @var Speed_Model_Dao_AdminUser
     */
    protected $dao;

    public function __construct(Speed_Model_Dao_Abstract $dao = null)
    {
        if ($dao) {
            $this->setDao($dao);
        } else {
            $this->setDao(new Speed_Model_Dao_AdminUser());
        }
    }

    public function validateUser($data = array())
    {

        if (empty($data)) {
            return false;
        }

        (empty($data['password'])) || ($data['password'] = $this->applyHashing($data['password']));
        return $this->dao->validateUser($data);
    }

    public function getActivationCode($data = array())
    {
        if (empty($data)) {
            return false;
        }

        return $this->dao->getActivationCode($data);
    }

    public function updatePassword($data, $activationCode)
    {
        if (empty($data) || empty($activationCode)) {
            return false;
        }

        $data = array('password' => $this->applyHashing($data['password']));
        return $this->dao->updatePassword($data, $activationCode);
    }

    public function save($data = array())
    {
        if (empty($data)) {
            return false;
        }

        $hashCode = 'Speed-KEY';

        (empty($data['password'])) || ($data['password'] = $this->applyHashing($data['password']));
        $data['activation_code'] = $this->applyHashing($data['username'] . $hashCode . $data['password']);
        $data['create_date']     = date('Y-m-d H:i:s');

        return $this->dao->create($data);
    }

    public function update($data = array(), $userId = null)
    {
        if (empty($data) || empty($userId)) {
            return false;
        }

        (empty($data['password'])) || ($data['password'] = $this->applyHashing($data['password']));

        $this->dao->modify($data, $userId);
        return true;
    }

    public function delete($examId = null)
    {
        if (empty($examId)) {
            return false;
        }

        return $this->dao->modify(array('user_status' => User_Model_UserStatus::BANNED), $examId);
    }

    protected function applyHashing($string)
    {
        return sha1($string);
    }

    public function getAllUsers()
    {
        return $this->dao->getAllUsers();
    }

    public function updateLastLoginTime($userId)
    {
        if (empty($userId)) {
            return false;
        }

        $data['last_login'] = date('Y-m-d H:i:s');
        return $this->dao->modify($data, $userId);
    }
}
