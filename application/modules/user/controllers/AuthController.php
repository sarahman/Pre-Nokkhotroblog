<?php

/**
 * Auth Controller
 * @category    Controller
 * @package     Auth
 * @author      Md. Eftakhairul Islam <eftakhairul@gmail.com>
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class User_AuthController extends Speed_Controller_ActionController
{
    public function indexAction()
    {
        $this->_redirect('/auth/login');
    }

    public function loginAction()
    {
        $this->disableLayout();
        $loginForm = new User_Form_Login();
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($loginForm->isValid($data)) {
                $userModel = new Speed_Model_User();
                $result    = $userModel->validateUser($data);
                if (empty($result)) {
                    $this->redirectForSuccess("/auth/login", "Please enter correct username and password.");
                    $loginForm->populate($data);
                } else {
                    $authNamespace           = new Zend_Session_Namespace('userInformation');
                    $authNamespace->userData = $result;
                    if (!isset($authNamespace->counter)) {
                        $authNamespace->counter = 1;
                    } else {
                        $authNamespace->counter++;
                    }
                    $userId = $authNamespace->userData['user_id'];
                    $userModel->updateLastLoginTime($userId);
                    $this->redirectForSuccess('/live', 'You have successfully logged in.');
                }
            } else {
                $loginForm->populate($data);
            }
        }
        $this->view->loginForm = $loginForm;
    }

    public function logoutAction()
    {
        $this->disableRendering();
        Zend_Session::destroy(true);
        $this->_redirect('/live');
    }

    public function forgetAction()
    {
        $this->disableLayout();
        $forgetPasswordForm = new User_Form_ForgotPassword();
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($forgetPasswordForm->isValid($data)) {
                $userModel = new Speed_Model_User();
                $result    = $userModel->getActivationCode($data);
                if (empty($result)) {
                    $this->redirectForFailure("/auth/forgot", "Please enter correct email address.");
                    $forgetPasswordForm->populate($data);
                } else {
                    $email = new Speed_Library_EmailManager();
                    $data  = array_merge($data, $result);
                    $email->send('forget-password', "Password Recovery", $data['email_address'], $data['username'], $data);
                    $this->redirectForSuccess('/auth/login', 'You have been sent an email for password recovery.');
                }
            } else {
                $forgetPasswordForm->populate($data);
            }
        }
        $this->view->forgetPasswordForm = $forgetPasswordForm;
    }

    public function resetPasswordAction()
    {
        $this->disableLayout();
        $resetPasswordForm = new User_Form_ResetPassword();
        $userModel         = new Speed_Model_User();
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($resetPasswordForm->isValid($data)) {
                $userModel->updatePassword($data, $data['code']);
                $this->redirectForSuccess('/auth/login', 'Your password has been reset successfully.');
            } else {
                $resetPasswordForm->populate($data);
            }
        } else {
            $activeCode = $this->_request->getParam('code');
            if (empty($activeCode)) {
                $this->redirectForFailure('/auth/forgot', 'Something went wrong! Please re-enter your email address.');
            } else {
                $resetPasswordForm->populate(array('code' => $activeCode));
            }
        }
        $this->view->headerTitle       = "Reset Password";
        $this->view->resetPasswordForm = $resetPasswordForm;
    }
}
