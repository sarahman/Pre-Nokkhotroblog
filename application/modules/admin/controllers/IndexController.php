<?php

/**
 * Index Controller
 * @category    Controller
 * @package     Admission
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://rightbrainsolution.com)
 */
class Admin_IndexController extends Speed_Controller_ActionController
{
    protected $semesterModel;

    protected function initialize()
    {
        $this->view->navBar = 'admin';
        $this->_helper->layout->setLayout('admin');
    }

    public function indexAction()
    {
        $this->_redirect("/admin/blogs/index");
    }
}