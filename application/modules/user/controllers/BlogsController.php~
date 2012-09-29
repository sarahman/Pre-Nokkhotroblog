<?php
/**
 * Blog Controller
 *
 * @category        Controller
 * @package         User
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_BlogsController extends Speed_Controller_ActionController
{
    public function init()
    {
        parent::init();
        $this->_helper->layout->setLayout('userprofile');
        
    }
    protected function initialize()
    {
        $this->_helper->layout->setLayout('userprofile');
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

        $blogs = $blogModel->getUserPosts($userId);

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
        $blogModel = new Blog_Model_Blog();
        $blogId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('userInformation');

        $blog = $blogModel->getDetail($blogId);

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
                $blogData = $blogModel->getDetail($blogId);

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
        $blogForm = new Blog_Form_BlogEntry(array(
            'blog_category_id' => $blogCategoryModel->getAll()
        ));

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            $data['description'] = stripslashes($this->_request->getParam('description'));


            if ($blogForm->isValid($data)) {

                $examModel = new Blog_Model_Blog();

                $result = $examModel->save($data);
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


    public function showAction()
    {
        $blogModel = new Blog_Model_Blog();
        $blogId = $this->_request->getParam('id');

        $commentsForm = new User_Form_CommentsForm(array('blog_id' => $blogId));

        $blog = $blogModel->getDetail($blogId);

        if (empty($blog)) {
            $this->redirectForFailure("/user/blogs", "Post has been deleted.");
        }

        $this->view->blog = $blog;

        $this->view->commentsForm = $commentsForm;
        ;

    }

    public function deleteAction()
    {
        $blogDeleteModel = new Blog_Model_BlogDisplay();

        $blogId = $this->_request->getParam('id');

        $status = $blogDeleteModel->delete($blogId);

        if ($status) {
            $this->redirectForSuccess("/user/blogs/display", "Blog deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/user/blogs/delete/id/{$blogId}", "Something went wrong. Please try again");
        }
    }


    public function addCommentAction()
    {

        //$this->validateUser();
        $blogModel = new Blog_Model_Blog();
        $blogId = $this->_request->getParam('id');

        $commentsForm = new User_Form_CommentsForm(array('user_id' => $blogId));

        $blog = $blogModel->getDetail($blogId);

        if (empty($blog)) {
            $this->redirectForFailure("/live", "Post has been deleted.");
        }

        $authNamespace = new Zend_Session_Namespace('userInformation');
        //$authNamespace->userData = $result;
        $authNamespace->userData['user_id'];


        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            $data['name'] = stripslashes($this->_request->getParam('name'));


            if ($commentsForm->isValid($data)) {

                $commentModel = new Blog_Model_BlogComment();

                $result = $commentModel->save($data);
                if (empty($result)) {
                    $this->setFailureMessage('There was a problem , Please try again.');
                } else {
                    //$this->view->errorMsg = "Blog has been posted successfully.";
                    $this->setSuccessMessage('Comment Posted sucessfully');
                    $this->redirectForSuccess('/user/blogs', 'You have successfully logged in.');
                }

            } else {
                $commentsForm->populate($data);
            }
        }

        $this->view->blog = $blog;

        $this->view->commentsForm = $commentsForm;

    }


    public function commentshow()

	{

	$this->validateUser();

        $CommentModel = new Blog_Model_BlogComment();
        $display = $CommentModell->getAll();
        $this->view->display = $display;


      }


    public function userprofileAction()
    {

	$this->validateUser();

        $userdetailModel = new User_Model_Userdetail();
        $userdetailId = $this->_request->getParam('id');

        $userdetail = $userdetailModel->getDetailForAdmin($userdetailId);

	
        if(empty($userdetail)){
            $this->redirectForFailure("/user/show","Post has been deleted.");
        }

        $this->view->userdetail = $userdetail;
     

    }
    
    public function trashBlogAction()
    {
        $userdetailModel = new Speed_Model_User();

        $authNamespace = new Zend_Session_Namespace('userInformation');
         $userName = $authNamespace->userData['username'];
        $userDetail = $userdetailModel->getDetailByUserName($userName);
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');        
        $blogModel = new Blog_Model_Blog();
 
        $blogtrash = $blogModel->getBlogtrash();	
        $this->view->Blogtrash = $blogtrash;
        $this->view->userDetail = $userDetail;

    }


}
