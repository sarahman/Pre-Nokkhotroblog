<?php
/**
 * notices Controller
 *
 * @notices    Controller
 * @package     Admin
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Admin_CommentsController extends Speed_Controller_ActionController
{
    protected $blogModel;

    protected function initialize()
    {
        $this->view->navBar = 'notice';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $commentDisplayModel = new Blog_Model_BlogComment();
        $display = $commentDisplayModel->getAll();
        $this->view->display = $display;

    }

 public function editAction()
             
            {
        
           $this->validateAdmin();
	   $authNamespace = new Zend_Session_Namespace('adminInformation');
           $adminId = $authNamespace->adminData['admin_id'];
           $blogcommentModel = new Blog_Model_BlogComment();
           $commentId = $this->_request->getParam('id');
	  
	
           $blogcommentModel->getDetail($commentId);
           $commentEntry =  new Admin_Form_CommentEntry(array(
                    'isEdit' => true,
                    'comments' => $commentId
                ));
          
       if ($this->_request->isPost()) {
	   $authNamespace = new Zend_Session_Namespace('adminInformation');
           $data = $this->_request->getParams();
	   $data['update_by'] = $authNamespace->adminData['admin_id'];
            if ($commentEntry->isValid($data)) {
           $result = $blogcommentModel->modify($data, $commentId);
       if (empty($result)) {
           $this->setFailureMessage('Problem , Please try again.');
           } else {
           $this->setSuccessMessage('comment has updated successfully.');
           }
         } else {
            $commentEntry->populate($data);
             }
            } else {

       if (empty($commentId)) {
             $this->setFailureMessage('Blog has not been found.');
                 } else {
             $commentModel = new Blog_Model_BlogComment();
             $commentData = $commentModel->getDetail($commentId);
        if (empty($commentData)) {
             $this->setFailureMessage('comment data has not been found.');
                } else {
             $commentEntry->populate($commentData);
                    }
                }
            }
            $this->view->CommentEntry= $commentEntry;

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



    public function deleteAction()
    {
        $this->validateAdmin();
        $commentDeleteModel = new Blog_Model_BlogComment();

        $commentId = $this->_request->getParam('id');

        $status = $commentDeleteModel->delete($commentId);

        if($status)
            {
               $this->redirectForSuccess("/admin/comments/","comment deleted Sucessfully.");
               }else{
               $this->redirectForFailure("/admin/comments/delete/id/{$commentId}","Something went wrong. Please try again");
            }
    }


    public function publishAction()
    {
        $data = array();

        $this->disableLayout();
        $commentModel = new Blog_Model_BlogComment();
	    $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['username'];
        $commentId = $this->_request->getParam('id');
	    $data = $this->_request->getParams();
        $comment = $commentModel->getDetail($commentId);
        $display = $commentModel->setPublishStatus($data,$commentId);

        $commentModel->updateTotalCommentCount($comment,$commentId);

        if($display){
            $this->redirectForSuccess("/admin/comments","comment status updated");
        }else{
            $this->redirectForFailure("/admin/blogs/show/id/{$commentId}","Something went wrong");
        }

    }

}
