<?php
/**
 * Admin Controller
 *
 * @panding    Controller
 * @package     Admin
 * @author      Md. sayeed hussain <sayeed.som@gmail.com>
 */
class Admin_PandingController extends Speed_Controller_ActionController
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
        $episodModel = new Admin_Model_Episod();
        $discussionModel = new Admin_Model_Discussion();  
        $blogs = $blogModel->getAllPostedBlog();
        $episod = $episodModel->getAll();
        $discussion = $discussionModel->getAllPandingDiscussion();
        $this->view->allPostedBlogs = $blogs;
	$this->view->episod = $episod;
	$this->view->discussion = $discussion;
        $groupModel = new Admin_Model_BlogGroup();
        $groups = $groupModel->getPandinghGroup();		
        $this->view->groups = $groups;
        


    }

}
