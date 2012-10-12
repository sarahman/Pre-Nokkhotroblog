<?php
/**
 * Blog Controller
 * @category        Controller
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_FeedbackController extends Speed_Controller_ActionController
{
    protected $blogModel;

    protected function initialize()
    {
        $this->_helper->layout->setLayout('general');
    }

    public function init()
    {
        parent::init();
        $categoryModel        = new Blog_Model_BlogCategory();
        $this->view->Category = $categoryModel->getAll();
        $pageModel            = new Admin_Model_Page();
        $this->view->pages    = $pageModel->getAll();
    }

    public function indexAction()
    {
        $options       = array(
            'isEdit' => false
        );
        $feedbacklForm = new Blog_Form_Feedback($options);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($feedbacklForm->isValid($data)) {
                $feedbackModel = new Blog_Model_Feedback();
                $result        = $feedbackModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/feedback', "There was a problem , Please try again.");
                } else {
                    $this->redirectForSuccess('/feedback', "Your feedback is Submited. Thank you for your feedback");
                }
            } else {
                $feedbacklForm->populate($data);
            }
        }
        $this->view->FeedbackForm = $feedbacklForm;
    }
}
