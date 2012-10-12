<?php

/**
 * Permission Controller
 * @category   Controller
 * @package    User
 * @copyright  Copyright (c) Right Brain Solution Ltd. http://rightbrainsolution.com
 * @author     Eftakhairul  Islam <eftakhairul@gmail.com>
 */
class User_PermissionsController extends Speed_Controller_ActionController
{
    protected function initialize()
    {
        $this->view->navBar = 'permissions';
    }

    public function indexAction()
    {
        $usersModel        = new Speed_Model_User();
        $users             = $usersModel->getAllUsers();
        $this->view->users = $users;
    }
}
