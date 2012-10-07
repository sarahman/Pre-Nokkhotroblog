<?php
/**
 * Group Type Controller
 *
 * @Group Type   Controller
 * @package     Blog
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Blog_BlogGroupsController extends Speed_Controller_ActionController
{


    public function init()
    {
        parent::init();
        $categoryModel = new Blog_Model_BlogCategory();
        $this->view->Category   = $categoryModel->getAll();
        $pageModel = new Admin_Model_Page();
        $this->view->pages = $pageModel->getAll();
    }

    public function indexAction()
    {
        //$this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $groupModel = new Blog_Model_BlogGroup();
        $userModel = new Speed_Model_User();
        $user = $this->_request->getParams();
        $userDetail = $userModel->getDetailByUsername($user['username']);
        $display = $groupModel->getGroupByUserName($userDetail['user_id']);
        $this->view->groups = $display;
        $this->view->blogInfo = $userDetail;

	$this->view->userDetail = $userDetail;

        $this->view->userDetail = $userDetail;
	$this->view->allgroup = $groupModel->getAll();       //display all group
    }

    public function editAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $userModel = new Speed_Model_User();
        $authNamespace = new Zend_Session_Namespace('userInformation');
        $username = $authNamespace->userData['username'];
        $userDetail = $userModel->getDetailByUsername($username);
        $groupModel = new Blog_Model_BlogGroup();
        $group = $this->_request->getParams();
        $groupModel->getDetail($group['groupid']);
        $groupTypeModel = new Admin_Model_BlogGroupType();

        $groupEntry = new Blog_Form_BlogGroupEntry(array(
            'blog_group_type_id' => $groupTypeModel->getAll(),
            'isEdit' => true,
            'blog_group_id' => $group['groupid']
        ));

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            if ($groupEntry->isValid($data)) {
                $result = $groupModel->modify($data, $data['blog_group_id']);
                if (empty($result)) {
                    $this->redirectForFailure("/groups/{$username}",'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/groups/{$username}",'Group has been updated successfully.');
                }
            } else {
                $groupEntry->populate($data);
            }
        } else {

            if (empty($group['groupid'])) {
                $this->redirectForFailure("/groups/{$username}",'No Group found');
            } else {
                $groupModel = new Blog_Model_BlogGroup();
                $groupData = $groupModel->getDetail($group['groupid']);
                if (empty($groupData)) {
                    $this->redirectForFailure("/groups/{$username}",'No Group found.');
                } else {
                    $groupEntry->populate($groupData);
                }
            }
        }
        $this->view->GroupEntry = $groupEntry;
        $this->view->blogInfo = $userDetail;

    }

    public function deleteAction()
    {
        $this->validateUser();
        $this->disableLayout();
        $authNamespace = new Zend_Session_Namespace('userInformation');
        $username = $authNamespace->userData['username'];
        $groupModel = new Blog_Model_BlogGroup();

        $group = $this->_request->getParams();
        $status = $groupModel->delete($group['groupid']);

        if ($status) {
            $this->redirectForSuccess("/groups/{$username}", "Group deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/groups/{$username}", "Something went wrong. Please try again");
        }
    }

    public function addAction()
    {
        $this->validateUser();
        $userModel = new Speed_Model_User();
        $linkData = $this->_request->getParams();
        $userDetail = $userModel->getDetailByUsername($linkData['username']);
        $this->_helper->layout->setLayout('userprofile');
        $groupTypeModel = new Admin_Model_BlogGroup();
        $groupEntry = new Blog_Form_BlogGroupEntry(array(
            'blog_group_type_id' => $groupTypeModel->getAll(),
            'isEdit' => false
        ));

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();

            if ($groupEntry->isValid($data)) {

                $groupModel = new Blog_Model_BlogGroup();

                $result = $groupModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure("/groups/{$linkData['username']}",'There was a problem , Please try again.');
                } else {

                    $this->redirectForSuccess("/groups/{$linkData['username']}",'Group Type inserted sucessfully');
                }

            } else {
                $groupEntry->populate($data);
            }
        }

        $this->view->GroupEntry = $groupEntry;
        $this->view->blogInfo   = $userDetail;

	$this->view->userDetail = $userDetail;

        $this->view->userDetail = $userDetail;


    }

    public function showAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('userprofile');

        $groupModel = new Admin_Model_BlogGroup();
        $groupId = $this->_request->getParam('id');

        $group = $groupModel->getDetailForAdmin($groupId);

        if (empty($group)) {
            $this->redirectForFailure("/live", "Group has been deleted.");
        }

        $this->view->notice = $group;
    }

    public function myBlogGroupPostListAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $blogGroupName = $this->_request->getParams();
        $blogGroupModel = new Blog_Model_BlogGroup();
        $userModel = new Speed_Model_User();
        $userDetail  = $userModel->getDetailByUsername($blogGroupName['username']);
        $blogGroupPostModel = new Blog_Model_BlogGroupPost();

        $data = $blogGroupModel->getBlogGroupDetailByPermalink($blogGroupName['permalink']);
        $posts = $blogGroupPostModel->getGroupBlogPosts($data['blog_group_id']);

        $this->view->blogGroupPosts = $posts;
        $this->view->blogGroupName = $blogGroupName['permalink'];
        $this->view->blogInfo = $userDetail;

    }

    public function myBlogGroupNewPostAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $this->validateUser();
        $blogGroupModel = new Blog_Model_BlogGroup();
        $linkData = $this->_request->getParams();
        $userModel = new Speed_Model_User();
        $userDetail = $userModel->getDetailByUsername($linkData['username']);
        $bloGroup = $blogGroupModel->getBlogGroupDetailByPermalink($linkData['permalink']);
        $novelForm = new Blog_Form_BlogGroupPost($options = array('isEdit' => false));
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            $data['blog_group_id'] = $bloGroup['blog_group_id'];
            if ($novelForm->isValid($data)) {
                $novelModel = new Blog_Model_BlogGroupPost();
                $result = $novelModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure("/groups/{$linkData['username']}", "There was a problem , Please try again.");
                } else {
                    $this->redirectForSuccess("/groups/{$linkData['username']}", "Your Group New Post is Submited.");
                }

            } else {
                $novelForm->populate($data);
            }
        }
        $this->view->BlogGroupPostForm = $novelForm;
        $this->view->blogInfo = $userDetail;
    }

    public function myBlogGroupSinglePostAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $userModel = new Speed_Model_User();
        $data = $this->_request->getParams();
        $userDetail = $userModel->getDetailByUsername($data['username']);
        $groupModel = new Blog_Model_BlogGroupPost();
        $groupBlogPost = $groupModel->getDetailByPermalink($data['permalink']);

        if (empty($groupBlogPost)) {
            $this->redirectForFailure("/{$data['username']}/my-blog-group/{$data['name']}/{$data['permalink']}", "Post has been deleted.");
        }

        $this->view->blogGroupPost = $groupBlogPost;
        $this->view->blogInfo = $userDetail;
    }

    public function myBlogGroupEditPostAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $linkData = $this->_request->getParams();
        $userModel = new Speed_Model_User();
        $authNamespace = new Zend_Session_Namespace('userInformation');
        $username = $authNamespace->userData['username'];
        $userDetail = $userModel->getDetailByUsername($username);
        $groupPostModel = new Blog_Model_BlogGroupPost();

        $groupPost = $groupPostModel->getDetailByPermalink($linkData['permalink']);
        $groupEntry = new Blog_Form_BlogGroupPost(array(
            'isEdit' => true,
            'blog_group_post_id' => $groupPost['blog_group_post_id']
        ));

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            if ($groupEntry->isValid($data)) {
                $result = $groupPostModel->modify($data, $groupPost['blog_group_post_id']);
                if (empty($result)) {
                    $this->redirectForFailure("/me",'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/me",'Post has been updated successfully.');
                }
            } else {
                $groupEntry->populate($data);
            }
        } else {

            if (empty($linkData['permalink'])) {
                $this->redirectForFailure("/me",'No post found');
            } else {
                $groupPostModel = new Blog_Model_BlogGroupPost();
                $groupData = $groupPostModel->getDetailByPermalink($linkData['permalink']);
                if (empty($groupData)) {
                    $this->redirectForFailure("/me",'No post found.');
                } else {
                    $groupEntry->populate($groupData);
                }
            }
        }

        $this->view->GroupPostEntry = $groupEntry;
        $this->view->blogInfo = $userDetail;
    }

    public function myBlogGroupDeletePostAction()
    {
        $this->validateUser();
        $this->disableLayout();
        $linkData = $this->_request->getParams();
        $authNamespace = new Zend_Session_Namespace('userInformation');
        $username = $authNamespace->userData['username'];
        if ($username != $linkData['username']) {
            $this->redirectForFailure("/me", "You are authorized to delete this post.");
        }
        $groupPostModel = new Blog_Model_BlogGroupPost();
        $groupData = $groupPostModel->getDetailByPermalink($linkData['permalink']);
        $group = $this->_request->getParams();
        $status = $groupPostModel->delete($groupData['blog_group_post_id']);

        if ($status) {
            $this->redirectForSuccess("/me", "Post deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/me", "Something went wrong. Please try again");
        }
    }


}
