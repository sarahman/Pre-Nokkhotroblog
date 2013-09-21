<?php
/**
 * Blogs Controller
 * @category    Controller
 * @package     Admin
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Admin_BlogsController extends Speed_Controller_ActionController
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
        $blogs     = $blogModel->getAllPostedBlog();
        $rowCount  = $blogModel->getAllPostCount();
        $this->setPagination($blogModel, $blogs, $rowCount, $action = 'index');
        $this->view->allPostedBlogs = $blogs;
    }

    public function editAction()
    {
        $this->validateAdmin();
        $blogCategoryModel = new Admin_Model_BlogCategory();
        $blogModel         = new Admin_Model_Blog();
        $blogId            = $this->_request->getParam('id');
        $blogForm          = new Admin_Form_BlogEntry(array(
            'blog_category_id' => $blogCategoryModel->getAll(),
            'isEdit' => true,
            'blog_id' => $blogId
        ));
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($blogForm->isValid($data)) {
                if ($blogForm->featured_image->receive()) {
                    $pathFeaturedImage      = $blogForm->featured_image->getFileName();
                    $data['featured_image'] = $pathFeaturedImage;
                    $result                 = $blogModel->modify($data, $data['blog_id']);
                }
                if (empty($result)) {
                    $this->redirectForFailure("/admin/blogs/show/id/{$data['blog_id']}", 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/admin/blogs/show/id/{$data['blog_id']}", 'Blog has updated successfully.');
                }
            } else {
                $blogForm->populate($data);
            }
        } else {
            if (empty($blogId)) {
                $this->redirectForFailure("/admin/blogs/show/id/{$blogId}", 'Blog has not been found.');
            } else {
                $blogModel = new Admin_Model_Blog();
                $blogData  = $blogModel->getDetailForAdmin($blogId);
                if (empty($blogData)) {
                    $this->redirectForFailure("/admin/blogs/show/id/{$blogId}", 'Blog data has not been found');
                } else {
                    $blogForm->populate($blogData);
                }
            }
        }
        $this->view->blogForm = $blogForm;
    }

    public function publishAction()
    {
        $data = array();
        $this->disableLayout();
        $blogId                   = $this->_request->getParam('id');
        $authNamespace            = new Zend_Session_Namespace('adminInformation');
        $adminId                  = $authNamespace->adminData['admin_id'];
        $data['last_modarate_by'] = $adminId;
        $blogModel                = new Admin_Model_Blog();
        $status                   = $blogModel->setPublishStatus($data, $blogId);
        if ($status) {
            $this->redirectForSuccess("/admin/blogs/show/id/{$blogId}", "Blog status updated");
        } else {
            $this->redirectForFailure("/admin/blogs/show/id/{$blogId}", "Something went wrong");
        }
    }

    public function pendingAction()
    {
        $data = array();
        $this->disableLayout();
        $blogId                   = $this->_request->getParam('id');
        $authNamespace            = new Zend_Session_Namespace('adminInformation');
        $adminId                  = $authNamespace->adminData['admin_id'];
        $data['last_modarate_by'] = $adminId;
        $blogModel                = new Admin_Model_Blog();
        $status                   = $blogModel->setPendingStatus($data, $blogId);
        if ($status) {
            $this->redirectForSuccess("/admin/blogs/show/id/{$blogId}", "Blog status updated");
        } else {
            $this->redirectForFailure("/admin/blogs/show/id/{$blogId}", "Something went wrong");
        }
    }

    public function selectAction()
    {
        $data = array();
        $this->disableLayout();
        $blogId                   = $this->_request->getParam('id');
        $authNamespace            = new Zend_Session_Namespace('adminInformation');
        $adminId                  = $authNamespace->adminData['admin_id'];
        $data['last_modarate_by'] = $adminId;
        $blogModel                = new Admin_Model_Blog();
        $status                   = $blogModel->setSelectStatus($data, $blogId);
        if ($status) {
            $this->redirectForSuccess("/admin/blogs/show/id/{$blogId}", "Blog select status updated");
        } else {
            $this->redirectForFailure("/admin/blogs/show/id/{$blogId}", "Something went wrong");
        }
    }

    public function stickyAction()
    {
        $data = array();
        $this->disableLayout();
        $blogId                   = $this->_request->getParam('id');
        $authNamespace            = new Zend_Session_Namespace('adminInformation');
        $adminId                  = $authNamespace->adminData['admin_id'];
        $data['last_modarate_by'] = $adminId;
        $blogModel                = new Admin_Model_Blog();
        $status                   = $blogModel->setSkStatus($data, $blogId); // setStickyPost setSkStatus
        if ($status) {
            $this->redirectForSuccess("/admin/blogs/show/id/{$blogId}", "Blog select status updated");
        } else {
            $this->redirectForFailure("/admin/blogs/show/id/{$blogId}", "Something went wrong");
        }
    }

    public function showAction()
    {
        $this->validateAdmin();
        $blogModel = new Admin_Model_Blog();
        $blogId    = $this->_request->getParam('id');
        $blog      = $blogModel->getDetailForAdmin($blogId);
        if (empty($blog)) {
            $this->redirectForFailure("/admin/blogs", "Post has been deleted.");
        }
        $this->view->blog = $blog;
    }

    protected function setPagination(Speed_Model_Abstract $model, $rows, $rowCount, $action = 'index')
    {
        $paginator                    = $model->getPaginator($rows, $rowCount);
        $this->view->paginator        = $paginator;
        $this->view->paginatorOptions = array(
            'path' => '',
            'itemLink' => "/admin/blogs/{$action}/page/%d"
        );
    }

// Trash Action
    public function trashAction()
    {
        $data = array();
        $this->disableLayout();
        $blogId                   = $this->_request->getParam('id');
        $authNamespace            = new Zend_Session_Namespace('userInformation');
        $adminId                  = $authNamespace->userData['user_id'];
        $data['last_modarate_by'] = $adminId;
        $trashModel               = new Admin_Model_Blog();
        $status                   = $trashModel->setTrashStatus($data, $blogId);
        if ($status) {
            $this->redirectForSuccess("/user/draft/index/id/{$blogId}", "Blog status updated");
        } else {
            $this->redirectForFailure("/user/draft/index/id/{$blogId}", "Something went wrong");
        }
    }

    public function publishItemAction()
    {
        $this->validateAdmin();
        $blogModel = new Admin_Model_Blog();
        $blogs     = $blogModel->getAllPublishedBlog();
        $rowCount  = $blogModel->getAllPostCount();
        $this->setPagination($blogModel, $blogs, $rowCount, $action = 'index');
        $this->view->allPublishBlogs = $blogs;
    }

    public function deleteAction()
    {
        $blogModel = new Admin_Model_Blog();
        $blogId    = $this->_request->getParam('id');
        $status    = $blogModel->delete($blogId);
        if ($status) {
            $this->redirectForSuccess("/admin/blogs", "Blog deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/blogs", "Something went wrong. Please try again");
        }
    }

    public function showStickyAction()
    {
        $this->validateAdmin();
        $blogModel             = new Admin_Model_Blog();
        $blogs                 = $blogModel->getAllStickyBlog();
        $this->view->getsticky = $blogs;
    }

    public function puplishStickyAction()
    {
        $data          = array();
        $stickyId      = $this->_request->getParam('id');
        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId       = $authNamespace->adminData['admin_id'];
        $stickyModel   = new Admin_Model_Blog();
        $status        = $stickyModel->setPublishSticky($data, $stickyId);
        if ($status) {
            $this->redirectForSuccess("/admin/blogs/show-sticky", "sticky status updated");
        } else {
            $this->redirectForFailure("/admin/blogs/show-sticky", "Something went wrong");
        }
    }
}
