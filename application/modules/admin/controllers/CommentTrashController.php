<?php
/**
 * Admin Controller
 *
 * @Trash    Controller
 * @package     Admin
 * @author      Md. sayeed hussain <sayeed.som@gmail.com>
 */
class Admin_CommentTrashController extends Speed_Controller_ActionController
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
        $commentModel = new Admin_Model_BlogComment(); 
        $comment = $commentModel->getAllComment();
        $this->view->comment = $comment;

    }


    public function showAction()
    {
        $this->validateAdmin();

        $commentModel = new Blog_Model_BlogComment();

        $commentId = $this->_request->getParam('id');

        $comment = $commentModel->getDetailForComment($commentId);

        if (empty($comment)) {
            $this->redirectForFailure("/admin/comment", "Notice has been deleted.");
        }
        
        $this->view->display = $comment;
    }


}
