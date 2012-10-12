<?php

/**
 * User Model
 * @category    Model
 * @package     Library
 * @author      Eftakhairul Islam <eftakhairul@gmail.com>
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://www.rightbrainsolution.com)
 */
class Speed_Model_User extends Speed_Model_Abstract
{
    /**
     * @var Speed_Model_Dao_User
     */
    protected $dao;
    protected $salt = "Speed-Key";

    public function __construct(Speed_Model_Dao_Abstract $dao = null)
    {
        if ($dao) {
            $this->setDao($dao);
        } else {
            $this->setDao(new Speed_Model_Dao_User());
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

        $data = array('password' => $this->applyHashing($data['password'], $this->salt));
        return $this->dao->updatePassword($data, $activationCode);
    }

    public function save($data = array())
    {
        if (empty($data)) {
            return false;
        }

        $authToken = $this->applyHashing($data['email_address'], $this->salt);

        (empty($data['password'])) || ($data['password'] = $this->applyHashing($data['password'], $this->salt));

        $data['activation_code'] = $this->applyHashing($data['username'], $this->salt);
        $data['auth_token']  = $authToken;
        $data['user_status'] = User_Model_UserStatus::INACTIVE;
        $data['create_date'] = date('Y-m-d H:i:s');

        return $this->dao->create($data);
    }

    public function update($data = array(), $userId = null)
    {
        if (empty($data) || empty($userId)) {
            return false;
        }

        (empty($data['password'])) || ($data['password'] = $this->applyHashing($data['password'], $this->salt));

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

    protected function applyHashing($string, $salt)
    {
        return sha1($string . $salt);
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

    public function getDetailByEmail($email)
    {
        if (empty($email)) {
            return false;
        }

        return $this->dao->getDetailByEmail($email);
    }

    public function getDetailByUsername($username)
    {
        if (empty($username)) {
            return false;
        }

        return $this->dao->getDetailByUsername($username);
    }

    public function modify($data, $userId)
    {
        if (empty($data) || empty($userId)) {
            return false;
        }

        $data['update_date'] = date('Y-m-d H:i:s');
        return $this->dao->modify($data, $userId);
    }

    public function activateNewUser($id, $activationCode)
    {
        $activate = $this->checkValidActivationCode($id, $activationCode);

        if ($activate == true) {

            $data['user_status'] = "active";
            $data['update_date'] = date('Y-m-d H:i:s');

            return $this->dao->modify($data, $id);
        } else {
            return false;
        }
    }

    public function checkValidActivationCode($id, $activationCode)
    {
        if (empty($id) || empty($activationCode)) {
            return false;
        }

        return $this->dao->checkValidActivationCode($id, $activationCode);
    }
}
