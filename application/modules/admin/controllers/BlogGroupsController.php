<?php
/**
 * Group Type Controller
 * @Group Type   Controller
 * @package     Admin
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Admin_BlogGroupsController extends Speed_Controller_ActionController
{
    public function indexAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $groupModel          = new Admin_Model_BlogGroup();
        $display             = $groupModel->getAll();
        $this->view->display = $display;
    }

    public function editAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $groupModel = new Admin_Model_BlogGroup();
        $groupId    = $this->_request->getParam('id');
        $groupModel->getDetail($groupId);
        $groupTypeModel = new Admin_Model_BlogGroupType();
        $groupEntry     = new Admin_Form_BlogGroupEntry(array(
            'blog_group_type_id' => $groupTypeModel->getAll(),
            'isEdit' => true,
            'blog_group_id' => $groupId
        ));
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($groupEntry->isValid($data)) {
                $result = $groupModel->modify($data, $data['blog_group_id']);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/blog-groups/index', 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/blog-groups/index', 'Group has been updated successfully.');
                }
            } else {
                $groupEntry->populate($data);
            }
        } else {
            if (empty($groupId)) {
                $this->redirectForFailure('/blog-groups/index', 'No Group found');
            } else {
                $groupModel = new Admin_Model_BlogGroup();
                $groupData  = $groupModel->getDetail($groupId);
                if (empty($groupData)) {
                    $this->redirectForFailure('/blog-groups/index', 'No Group found.');
                } else {
                    $groupEntry->populate($groupData);
                }
            }
        }
        $this->view->GroupEntry = $groupEntry;
    }

    public function deleteAction()
    {
        $this->validateAdmin();
        $groupModel = new Admin_Model_BlogGroup();
        $groupId    = $this->_request->getParam('id');
        $status     = $groupModel->delete($groupId);
        if ($status) {
            $this->redirectForSuccess("/admin/blog-groups/index", "Group deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/blog-groups/index", "Something went wrong. Please try again");
        }
    }

    public function addAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $groupTypeModel = new Admin_Model_BlogGroupType();
        $groupEntry     = new Admin_Form_BlogGroupEntry(array(
            'blog_group_type_id' => $groupTypeModel->getAll(),
            'isEdit' => false
        ));
        if ($this->_request->isPost()) {
            $data               = $this->_request->getParams();
            $data['group_type'] = stripslashes($this->_request->getParam('group_type'));
            if ($groupEntry->isValid($data)) {
                $groupModel = new Admin_Model_BlogGroup();
                $result     = $groupModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/blog-groups/index', 'There was a problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/blog-groups/index', 'Group Type inserted sucessfully');
                }
            } else {
                $groupEntry->populate($data);
            }
        }
        $this->view->GroupEntry = $groupEntry;
    }

    public function showAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $groupModel = new Admin_Model_BlogGroup();
        $groupId    = $this->_request->getParam('id');
        $group      = $groupModel->getDetailForAdmin($groupId);
        if (empty($group)) {
            $this->redirectForFailure("/admin/blog-groups", "Group has been deleted.");
        }
        $this->view->notice = $group;
    }

    public function publishAction()
    {
        $data = array();
        $this->disableLayout();
        $groupId       = $this->_request->getParam('id');
        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId       = $authNamespace->adminData['admin_id'];
        $groupModel    = new Admin_Model_BlogGroup();
        $status        = $groupModel->setPublishStatus($data, $groupId);
        if ($status) {
            $this->redirectForSuccess("/admin/blog-groups", "Group status updated");
        } else {
            $this->redirectForFailure("/admin/blog-groups", "Something went wrong");
        }
    }

    public function blogGroupPublishStatusAction()
    {
        $this->disableLayout();
        $blogGroupModel                  = new Admin_Model_BlogGroup();
        $data                            = $this->_request->getParams();
        $blogGroupDetail                 = $blogGroupModel->getDetail($data['id']);
        $authNamespace                   = new Zend_Session_Namespace('adminInformation');
        $adminId                         = $authNamespace->adminData['admin_id'];
        $data['last_moderate_by']        = $adminId;
        $data['blog_group_is_published'] = $blogGroupDetail['blog_group_is_published'];
        $status                          = $blogGroupModel->changeBlogGroupPublishStatus($data, $blogGroupDetail['blog_group_id']);
        if ($status) {
            $this->redirectForSuccess('/admin/blog-groups', "'Novel status has been changed Sucessfully.");
        } else {
            $this->redirectForFailure('/admin/blog-groups', "Something went wrong. Please try again");
        }
    }

    public function blogGroupPostPublishStatusAction()
    {
        $this->disableLayout();
        $blogGroupModel                       = new Admin_Model_BlogGroupPost();
        $data                                 = $this->_request->getParams();
        $blogGroupDetail                      = $blogGroupModel->getDetail($data['id']);
        $authNamespace                        = new Zend_Session_Namespace('adminInformation');
        $adminId                              = $authNamespace->adminData['admin_id'];
        $data['last_moderate_by']             = $adminId;
        $data['blog_group_post_is_published'] = $blogGroupDetail['blog_group_post_is_published'];
        $status                               = $blogGroupModel->changeBlogGroupPostPublishStatus($data, $blogGroupDetail['blog_group_post_id']);
        if ($status) {
            $this->redirectForSuccess("admin/blog-groups/show-group-blog-post/id/{$data['id']}", "'Novel status has been changed Sucessfully.");
        } else {
            $this->redirectForFailure("admin/blog-groups/show-group-blog-post/id/{$data['id']}", "Something went wrong. Please try again");
        }
    }

    public function blogGroupPostsAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $BlogGroupPostModel         = new Admin_Model_BlogGroupPost();
        $blogGroupId                = $this->_request->getParam('id');
        $blogGroupPosts             = $BlogGroupPostModel->getPostByBlogGroupId($blogGroupId);
        $this->view->blogGroupPosts = $blogGroupPosts;
    }

    public function showGroupBlogPostAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $groupModel    = new Admin_Model_BlogGroupPost();
        $groupPostId   = $this->_request->getParam('id');
        $groupBlogPost = $groupModel->getDetail($groupPostId);
        if (empty($groupBlogPost)) {
            $this->redirectForFailure("/admin/blog-groups", "Post has been deleted.");
        }
        $this->view->blogGroupPost = $groupBlogPost;
    }

    public function editBlogGroupPostAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $groupModel  = new Admin_Model_BlogGroupPost();
        $groupPostId = $this->_request->getParam('id');
        $groupModel->getDetail($groupPostId);
        $groupPostEntry = new Admin_Form_BlogGroupPost(array(
            'isEdit' => true,
            'blog_group_post_id' => $groupPostId
        ));
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($groupPostEntry->isValid($data)) {
                $result = $groupModel->modify($data, $groupPostId);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/blog-groups/index', 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/blog-groups/index', 'Group has been updated successfully.');
                }
            } else {
                $groupPostEntry->populate($data);
            }
        } else {
            if (empty($groupPostId)) {
                $this->redirectForFailure('/blog-groups/index', 'No Group found');
            } else {
                $groupModel = new Admin_Model_BlogGroupPost();
                $groupData  = $groupModel->getDetail($groupPostId);
                if (empty($groupData)) {
                    $this->redirectForFailure('/blog-groups/index', 'No Group found.');
                } else {
                    $groupPostEntry->populate($groupData);
                }
            }
        }
        $this->view->editGroupPost = $groupPostEntry;
    }

    public function deleteBlogGroupPostAction()
    {
        $this->validateAdmin();
        $groupPostModel = new Admin_Model_BlogGroupPost();
        $groupId        = $this->_request->getParam('id');
        $status         = $groupPostModel->delete($groupId);
        if ($status) {
            $this->redirectForSuccess("/admin/blog-groups/index", "Post deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/blog-groups/index", "Something went wrong. Please try again");
        }
    }
}
