<?php
/**
 * Admin Controller
 *
 * @Publish    Controller
 * @package     Admin
 * @author      Md. sayeed hussain <sayeed.som@gmail.com>
 */
class Admin_PublishController extends Speed_Controller_ActionController
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
	
        $blogs = $blogModel->getPublishBlog();
        $episod = $episodModel->getAllPublishEpisods();
	$discussion = $discussionModel->getAllPublishDiscussion();
			
        $this->view->display = $episod;
        $this->view->allPublishBlogs = $blogs;
        $this->view->discussion = $discussion;

        $groupModel = new Admin_Model_BlogGroup();
        $groups = $groupModel->getPublishGroup();		
        $this->view->groups = $groups;


    }
    public function showAction()
    {
        $this->validateAdmin();

        $blogModel = new Admin_Model_Blog();
        $blogId = $this->_request->getParam('id');
	$commentsId = $this->_request->getParam('id');
        $blog = $blogModel->getDetailForAdmin($blogId);
        $commentDisplayModel = new Admin_Model_BlogComment();
        $comment = $commentDisplayModel->getCommentByBlog($commentsId);

        if (empty($blog)) {
            $this->redirectForFailure("/admin/publish", "Post has been deleted.");
        }

        $this->view->blog = $blog;
	$this->view->comment = $comment;
    }

    public function showCommentAction()
    {
        $this->validateAdmin();

        $commentModel = new Blog_Model_BlogComment();

        $commentId = $this->_request->getParam('id');

        $comment = $commentModel->getDetailForComment($commentId);

        if (empty($comment)) {
            $this->redirectForFailure("/admin/publish", "Notice has been deleted.");
        }
        
        $this->view->display = $comment;
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

 public function deleteAction()
    {
        $this->validateAdmin();
        $commentDeleteModel = new Blog_Model_BlogComment();

        $commentId = $this->_request->getParam('id');

        $status = $commentDeleteModel->delete($commentId);

        if($status)
            {
               $this->redirectForSuccess("admin/publish/show/id/{$commentId}","comment deleted Sucessfully.");
               }else{
               $this->redirectForFailure("admin/publish/show/id/{$commentId}","Something went wrong. Please try again");
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
            $this->redirectForSuccess("/admin/publish/show/id/{$commentId}","comment status updated");
        }else{
            $this->redirectForFailure("/admin/publish/show/id/{$commentId}","Something went wrong");
        }

    }

    public function trashAction()
    {
        $data = array();

        $this->disableLayout();

        $commentId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        //$data['last_modarate_by'] = $adminId;

        $blogModel = new Admin_Model_BlogComment();
        $status = $blogModel->setPendingStatus($data, $commentId);

        if ($status) {
           $this->redirectForSuccess("/admin/publish/show/id/{$commentId}","comment status updated");
        } else {
           $this->redirectForFailure("/admin/publish/show/id/{$commentId}","Something went wrong");
        }

    }

    public function showDiscussionsAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');   
        $discussionModel = new Admin_Model_Discussion();				
        $discussionId = $this->_request->getParam('id');			
	$commentsId = $this->_request->getParam('id');
        $commentDisplayModel = new Admin_Model_DiscussionComment();
        $comment = $commentDisplayModel->getCommentByDiscussion($commentsId);
        $discussion = $discussionModel->getDetailForAdmin($discussionId);		

        if (empty($discussion)) {			
            $this->redirectForFailure("/admin/publish", "Discussions has been deleted.");		
        }

        $this->view->discussion = $discussion;
	$this->view->comment = $comment;		
    }

    public function publishDiscussionAction()
    {
        $data = array();
        $discussionId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        $data['update_by'] = $adminId;

        $discussionModel = new Admin_Model_DiscussionComment();                
        $status = $discussionModel->setPublishStatus($data, $discussionId); 

        if ($status) {
            $this->redirectForSuccess("/admin/publish/show-discussions/id/{$discussionId}", "Discussion status updated");
        } else {
            $this->redirectForFailure("/admin/publish/show-discussions/id/{$discussionId}", "Something went wrong");
        }

    }

    public function trashDiscussionAction()
    {
         $data = array();

        $discussionId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        $data['update_by'] = $adminId;

        $discussionModel = new Admin_Model_DiscussionComment();                
        $status = $discussionModel->setTrashStatus($data, $discussionId); 

        if ($status) {
            $this->redirectForSuccess("/admin/publish/show-discussions/id/{$discussionId}", "Discussion status updated");
        } else {
            $this->redirectForFailure("/admin/publish/show-discussions/id/{$discussionId}", "Something went wrong");
        }

    }
    public function showEpisodAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $episodCommentModel=new Admin_Model_EpisodComment();        
        $episodModel = new Admin_Model_Episod();				
        $episodId = $this->_request->getParam('id');			
	$commentId = $this->_request->getParam('id');

        $episod = $episodModel->getDetailForEpisod($episodId);		
	$comment = $episodCommentModel->getDetailByComment($commentId);
        if (empty($episod)) {			
            $this->redirectForFailure("/admin/publish", "Episods has been deleted.");		
        }

        $this->view->episod = $episod;
        $this->view->comment = $comment;		
    }

    public function trashEpisodeAction()
    {
        $data = array();

        $this->disableLayout();

        $userId = $this->_request->getParam('id');

        $blogModel = new Admin_Model_Blog();
        $status = $blogModel->setTrashStatus($data, $userId);
        $this->view->status = $status;

        if ($status) {
            $this->redirectForSuccess("/admin/publish/index/id/{$userId}", "User select Blog status updated");
        } else {
            $this->redirectForFailure("/admin/publish/index/id/{$userId}", "Something went wrong");
        }

    }
public function publishCommentAction()
    {
        $data = array();

        $this->_helper->layout->setLayout('admin');

        $commentId = $this->_request->getParam('id');   

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        $data['update_by'] = $adminId;

        $episodecommentModel = new Admin_Model_EpisodComment();      
        $status = $episodecommentModel->setPublishStatus($data, $commentId);     

        if ($status) {
            $this->redirectForSuccess("/admin/publish/show-episod/id/{$commentId}", "Comment status updated");  
        } else {
            $this->redirectForFailure("/admin/publish/show-episod/id/{$commentId}", "Something went wrong");   
        }

    }
    



}
