<?php
/**
 * Comments Controller
 * @category    Controller
 * @package     User
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://rightbrainsolution.com)
 */
class User_CommentsController extends Speed_Controller_CrudController
{
    public function init()
    {
        parent::init();
        $userModel                 = new Speed_Model_User();
        $blogModel                 = new Blog_Model_Blog();
        $authNamespace             = new Zend_Session_Namespace('userInformation');
        $userId                    = $authNamespace->userData['user_id'];
        $this->view->selectedPosts = $blogModel->getSelectedPosts();
        $this->view->newBlogger    = $userModel->getAllUsers();
        if (!empty($authNamespace->userData)) {
            $this->view->userProfile = $userModel->getDetail($userId);
        }
        $this->view->recentPosts = $blogModel->getRecentPosts();
        $this->view->userPosts   = $blogModel->getUserPosts($userId);
        $categoryModel           = new Blog_Model_BlogCategory();
        $this->view->Category    = $categoryModel->getAll();
        $pageModel               = new Admin_Model_Page();
        $this->view->pages       = $pageModel->getAll();
    }

    public function indexAction()
    {
        $authNamespace = new Zend_Session_Namespace('userInformation');
        if (!empty ($authNamespace->userData['username'])) {
            $userId = $authNamespace->userData['user_id'];
        }
        $id = $this->_request->getParam('id');
        if (!empty ($id)) {
            $userId = $id;
        }
        $blogModel = new Blog_Model_Blog();
        $blogs     = $blogModel->getUserPosts($userId);
        if (empty($blogs)) {
            $this->redirectForFailure("/blog/index", "No post publish yet");
        } else {
            $this->view->userPosts = $blogs;
        }
    }

    public function editAction()
    {
        $this->validateUser();
        $blogCategoryModel = new Blog_Model_BlogCategory();
        $blogModel         = new Blog_Model_Blog();
        $blogId            = $this->_request->getParam('id');
        $authNamespace     = new Zend_Session_Namespace('userInformation');
        $blog              = $blogModel->getDetail($blogId);
        if ($blog['create_by'] != $authNamespace->userData['user_id']) {
            $this->redirectForFailure('/blog/index', 'You are not permitted to edit this blog');
        }
        $blogForm = new Blog_Form_BlogEntry(array(
            'blog_category_id' => $blogCategoryModel->getAll(),
            'isEdit' => true,
            'blog_id' => $blogId
        ));
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($blogForm->isValid($data)) {
                $result = $blogModel->modify($data, $data['blog_id']);
                if (empty($result)) {
                    $this->setFailureMessage('Problem , Please try again.');
                } else {
                    $this->setSuccessMessage('Blog has updated successfully.');
                }
            } else {
                $blogForm->populate($data);
            }
        } else {
            if (empty($blogId)) {
                $this->setFailureMessage('Blog has not been found.');
            } else {
                $blogModel = new Blog_Model_Blog();
                $blogData  = $blogModel->getDetail($blogId);
                if (empty($blogData)) {
                    $this->setFailureMessage('Blog data has not been found.');
                } else {
                    $blogForm->populate($blogData);
                }
            }
        }
        $this->view->blogForm = $blogForm;
    }

    public function addAction()
    {
        $this->validateUser();
        $blogCategoryModel = new Blog_Model_BlogCategory();
        $blogForm          = new Blog_Form_BlogEntry(array(
            'blog_category_id' => $blogCategoryModel->getAll()
        ));
        if ($this->_request->isPost()) {
            $data                = $this->_request->getParams();
            $data['description'] = stripslashes($this->_request->getParam('description'));
            if ($blogForm->isValid($data)) {
                $examModel = new Blog_Model_Blog();
                $result    = $examModel->save($data);
                if (empty($result)) {
                    $this->setFailureMessage('There was a problem , Please try again.');
                } else {
                    //$this->view->errorMsg = "Blog has been posted successfully.";
                    $this->setSuccessMessage('Blog Posted sucessfully');
                }
            } else {
                $blogForm->populate($data);
            }
        }
        $this->view->blogForm = $blogForm;
    }

    public function deleteAction()
    {
        $blogDeleteModel = new Blog_Model_BlogDisplay();
        $blogId          = $this->_request->getParam('id');
        $status          = $blogDeleteModel->delete($blogId);
        if ($status) {
            $this->redirectForSuccess("/user/blogs/display", "Blog deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/user/blogs/delete/id/{$blogId}", "Something went wrong. Please try again");
        }
    }

    public function commentAction()
    {
        $commentModel = new User_Model_Comment();
        $userId       = $this->_request->getParam('id');
        $CommentEntry = new User_Form_CommentEntry(array('user_id' => $userId));
        $comment      = $commentModel->getDetail($userId);
        if (empty($comment)) {
            $this->redirectForFailure("/user/blogs", "Post has been deleted.");
        }
        //$this->view->blog = $blog;
        $this->view->CommentEntry = $CommentEntry;
    }

    public function showAction()
    {
        //$this->validateAdmin();
        $this->_helper->layout->setLayout('userprofile');
        //$userModel = new Speed_Model_User();
        //$userName = $this->_request->getParams();
        //$userDetail = $userModel->getDetailByUsername($userName['username']);
        $commentModel = new Blog_Model_BlogComment();
        $commentId    = $this->_request->getParam('id');
        $comment      = $commentModel->getDetailForComment($commentId);
        if (empty($comment)) {
            $this->redirectForFailure("/user/comment", "Notice has been deleted.");
        }
        $this->view->display = $comment;
        //$this->view->userDetail = $userDetail;
    }
}
