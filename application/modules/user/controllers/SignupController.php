<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zafar
 * Date: 6/16/12
 * Time: 1:29 AM
 * To change this template use File | Settings | File Templates.
 */
class User_SignupController extends Speed_Controller_ActionController
{
    public function indexAction()
    {
        $this->disableLayout();
        $options  = array(
            'isEdit' => false
        );
        $userForm = new User_Form_SignupForm($options);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($userForm->isValid($data)) {
                $userModel = new Speed_Model_User();
                $result    = $userModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/user/auth/login', 'There was a problem , Please try again.');
                } else {
                    if (!empty($data['email_address'])) {
                        $notifier   = new User_Model_Notifier();
                        $userDetail = $userModel->getDetailByEmail($data['email_address']);
                        $notifier->sendRegistrationEmail($userDetail);
                    }
                    $this->redirectForSuccess('/user/auth/login', "Your registration is complete. Please sign in here.");
                }
            } else {
                $userForm->populate($data);
            }
        }
        $this->view->userForm = $userForm;
        ;
    }

    public function addAction()
    {
        $options  = array(
            'isEdit' => false
        );
        $userForm = new User_Form_SignupForm($options);
        $data     = array(
            'form' => $userForm,
            'model' => $this->userModel,
            'redirectLink' => '/user/auth/login',
            'message' => 'Your registration is complete. Please sign in here.'
        );
        $this->create($data);
        $this->view->userForm = $userForm;
    }

    public function editAction()
    {
        $options  = array(
            'isEdit' => true
        );
        $userForm = new User_Form_SignupForm($options);
        $data     = array(
            'form' => $userForm,
            'model' => $this->userModel,
            'redirectLink' => '/user/auth/login',
            'id' => $this->_request->getParam('id'),
            'message' => 'Your registration is complete. Please sign in here.'
        );
        $this->update($data);
        $this->view->editUserForm = $userForm;
    }

    public function deleteAction()
    {
        $this->delete($this->_request->getParam('id'), $this->userModel);
    }

    public function profileAction()
    {
    }

    public function activateUserAccountAction() //ADDED BY ZAFAR
    {
        $this->disableLayout();
        $data      = $this->_request->getUserParams();
        $userModel = new Speed_Model_User();
        $status    = $userModel->activateNewUser($data['id'], $data['code']);
        if ($status != false) {
            $this->redirectForSuccess('/live', 'Your account is activated. Please login.');
        } else {
            $this->redirectForFailure('/live', 'Your activation code is invalid.');
        }
    }
}
