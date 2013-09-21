<?php
/**
 * Admin Controller
 *
 * @Selected    Controller
 * @package     Admin
 * @author      Md. sayeed hussain <sayeed.som@gmail.com>
 */
class Admin_SelectedController extends Speed_Controller_ActionController
{

    protected $blogModel;

    protected function initialize()
    {
        $this->view->navBar = 'admin';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $blogModel = new Admin_Model_Blog();
        $blogs = $blogModel->getSelectedPosts();
        $selected = $blogModel->getMakeSelectedPosts();
	$this->view->selected = $blogs;
	$this->view->makeselected = $selected;




    }

}
