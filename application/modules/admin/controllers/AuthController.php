<?php

/**
 * Auth Controller
 * @category    Controller
 * @package     Auth
 * @author      Md. Eftakhairul Islam <eftakhairul@gmail.com>
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright   Copyright (c) Right Brain Solution Ltd. <info@rightbrainsolution.com>
 */
class Admin_AuthController extends Speed_Controller_ActionController
{
    public function indexAction()
    {
        $this->_redirect('/admin/auth/login');
    }

    public function loginAction()
    {
        $this->disableLayout();
        $loginForm = new Admin_Form_Login();
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($loginForm->isValid($data)) {
                $userModel = new Speed_Model_AdminUser();
                $result    = $userModel->validateUser($data);
                if (empty($result)) {
                    $this->redirectForFailure("/admin/auth/login", "Please enter correct username and password.");
                    $loginForm->populate($data);
                } else {
                    $authNamespace            = new Zend_Session_Namespace('adminInformation');
                    $authNamespace->adminData = $result;
                    $userId                   = $authNamespace->adminData['admin_id'];
                    $userModel->updateLastLoginTime($userId);
                    $this->redirectForSuccess('/admin/index', 'You have successfully logged in.');
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
        $this->_redirect('/blog/index');
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
                    $this->redirectForFailure("/user/auth/forget", "Please enter correct email address.");
                    $forgetPasswordForm->populate($data);
                } else {
                    $email = new Speed_Library_EmailManager();
                    $data  = array_merge($data, $result);
                    $email->send('forget-password', "Password Recovery", $data['email_address'], $data['username'], $data);
                    $this->redirectForSuccess('/user/auth/login', 'You have been sent an email for password recovery.');
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
                $this->redirectForSuccess('/user/auth/login', 'Your password has been reset successfully.');
            } else {
                $resetPasswordForm->populate($data);
            }
        } else {
            $activeCode = $this->_request->getParam('code');
            if (empty($activeCode)) {
                $this->redirectForFailure('/user/auth/forget', 'Something went wrong! Please re-enter your email address.');
            } else {
                $resetPasswordForm->populate(array('code' => $activeCode));
            }
        }
        $this->view->headerTitle       = "Reset Password";
        $this->view->resetPasswordForm = $resetPasswordForm;
    }
}