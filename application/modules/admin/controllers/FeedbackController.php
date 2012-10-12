<?php
/**
 * Auth Controller
 * @category    Controller
 * @package     Auth
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright   Copyright (c) Right Brain Solution Ltd. <info@rightbrainsolution.com>
 */
class Admin_FeedbackController extends Speed_Controller_ActionController
{
    protected $blogModel;

    protected function initialize()
    {
        $this->view->navBar = 'feedback';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $feedbackyModel      = new Admin_Model_Feedback();
        $display             = $feedbackyModel->getAll();
        $this->view->Display = $display;
    }

    public function deleteAction()
    {
        $this->validateAdmin();
        $feedbackyModel = new Admin_Model_Feedback();
        $feedbackId     = $this->_request->getParam('id');
        $status         = $feedbackyModel->delete($feedbackId);
        if ($status) {
            $this->redirectForSuccess('/admin/feedback', "Feedback was deleted Sucessfully.");
        } else {
            $this->redirectForFailure('/admin/feedback/', "Something went wrong. Please try again");
        }
    }

    public function showAction()
    {
        $this->validateAdmin();
        $feedbackyModel       = new Admin_Model_Feedback();
        $feedbackId           = $this->_request->getParam('id');
        $displayp             = $feedbackyModel->getFeedbackDetailForAdmin($feedbackId);
        $this->view->displayp = $displayp;
    }
}
