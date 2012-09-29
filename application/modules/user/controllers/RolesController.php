<?php
/**
 * Roles Controller
 *
 * @category   Controller
 * @package    User
 * @copyright  Copyright (c) Right Brain Solution Ltd. http://rightbrainsolution.com
 * @author     Eftakhairul  Islam <eftakhairul@gmail.com>
 */
class User_RolesController extends Speed_Controller_ActionController
{
    protected function initialize()
    {
        $this->view->navBar = 'roles';
    }

    public function indexAction()
    {
    }

    public function addAction()
    {
        $this->disableLayout();
    }
}
