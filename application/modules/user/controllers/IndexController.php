<?php

class User_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->_redirect("/user/auth");
    }
}