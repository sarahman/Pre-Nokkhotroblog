<?php
/**
 * Admin Controller
 *
 * @Trash    Controller
 * @package     Admin
 * @author      Md. sayeed hussain <sayeed.som@gmail.com>
 */
class Admin_TrashsController extends Speed_Controller_ActionController
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
        $blogTrashModel = new Admin_Model_Blog(); 
        $trash = $blogTrashModel->getAllTrash();
        $this->view->trash = $trash;
        $episod = $blogTrashModel->getAllEpisodeTrash();
        $this->view->episod = $episod;
        $discussionModel = new Admin_Model_Discussion(); 
        $discussion = $discussionModel->getAllDiscussionTrash();
        $this->view->discussion = $discussion;
        $commentModel = new Admin_Model_BlogComment(); 
        $comment = $commentModel->getAllComment();
        $this->view->comment = $comment;


    }
 public function showAction()
    {
        $this->validateAdmin();

        $blogModel = new Admin_Model_Blog();
        $blogId = $this->_request->getParam('id');

        $blog = $blogModel->getDetailForAdmin($blogId);

        if (empty($blog)) {
            $this->redirectForFailure("/admin/trashs", "Post has been deleted.");
        }

        $this->view->blog = $blog;
    }
 public function editAction()
    {
        $this->validateAdmin();

        $blogCategoryModel = new Admin_Model_BlogCategory();
        $blogModel = new Admin_Model_Blog();
        $blogId = $this->_request->getParam('id');

        $blogForm = new Admin_Form_BlogEntry(array(
            'blog_category_id' => $blogCategoryModel->getAll(),
            'isEdit' => true,
            'blog_id' => $blogId
        ));

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();

            if ($blogForm->isValid($data)) {

                if ($blogForm->featured_image->receive()) {

                    $pathFeaturedImage = $blogForm->featured_image->getFileName();

                    $data['featured_image'] = $pathFeaturedImage;


                    $result = $blogModel->modify($data, $data['blog_id']);

                }


                if (empty($result)) {
                    $this->redirectForFailure("/admin/trashs/show/id/{$data['blog_id']}", 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/admin/trashs/show/id/{$data['blog_id']}", 'Blog has updated successfully.');
                }

            } else {
                $blogForm->populate($data);
            }

        } else {

            if (empty($blogId)) {


                $this->redirectForFailure("/admin/trashs/show/id/{$blogId}", 'Blog has not been found.');
            } else {

                $blogModel = new Admin_Model_Blog();
                $blogData = $blogModel->getDetailForAdmin($blogId);

                if (empty($blogData)) {

                    $this->redirectForFailure("/admin/trashs/show/id/{$blogId}", 'Blog data has not been found');
                } else {
                    $blogForm->populate($blogData);
                }
            }
        }

        $this->view->blogForm = $blogForm;
    }
    public function deleteAction()
    {
        $blogModel = new Admin_Model_Blog();

        $blogId = $this->_request->getParam('id');

        $status = $blogModel->delete($blogId);

        if ($status) {
            $this->redirectForSuccess("/admin/trashs", "Blog deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/trashs", "Something went wrong. Please try again");
        }
    }
    public function trashAction()
    {
        $data = array();

        $this->disableLayout();

        $userId = $this->_request->getParam('id');

        $blogModel = new Admin_Model_Blog();
        $status = $blogModel->setTrashStatus($data, $userId);
        $this->view->status = $status;

        if ($status) {
            $this->redirectForSuccess("/admin/trashs/index/id/{$userId}", "User select Blog status updated");
        } else {
            $this->redirectForFailure("/admin/trashs/index/id/{$userId}", "Something went wrong");
        }

    }


public function showEpisodeAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
                
        $episodModel = new Admin_Model_Episod();				
        $episodId = $this->_request->getParam('id');			

        $episod = $episodModel->getDetailForEpisod($episodId);		

        if (empty($episod)) {			
            $this->redirectForFailure("/admin/trashs", "Episods has been deleted.");		
        }

        $this->view->episod = $episod;		
    }

    public function deleteEpisodeAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $episodModel = new Admin_Model_Episod();             

        $episodId = $this->_request->getParam('id');	

        $status = $episodModel->delete($episodId);	

        if ($status) {
            $this->redirectForSuccess("/admin/trashs", "Episod deleted Sucessfully.");			
        } else {
            $this->redirectForFailure("/admin/trashs", "Something went wrong. Please try again");		
        }
    }
    public function trashDiscussionAction()
    {
         $data = array();

        $discussionId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        $data['update_by'] = $adminId;

        $discussionModel = new Admin_Model_Discussion();                
        $status = $discussionModel->setTrashStatus($data, $discussionId); 

        if ($status) {
            $this->redirectForSuccess("/admin/trashs", "Discussion status updated");
        } else {
            $this->redirectForFailure("/admin/trashs", "Something went wrong");
        }

    }
   public function deleteDiscussionAction()
    {
        $this->validateAdmin();
       
        $discussionModel = new Admin_Model_Discussion();             

        $discussionId = $this->_request->getParam('id');	

        $status = $discussionModel->delete($discussionId);	

        if ($status) {
            $this->redirectForSuccess("/admin/trashs/index", "Discussions deleted Sucessfully.");			
        } else {
            $this->redirectForFailure("/admin/trashs/index", "Discussions went wrong. Please try again");		
        }
    }



}
