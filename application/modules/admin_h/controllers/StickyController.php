<?php
/**
 * Admin Controller
 *
 * @Sticky    Controller
 * @package     Admin
 * @author      Md. sayeed hussain <sayeed.som@gmail.com>
 */
class Admin_StickyController extends Speed_Controller_ActionController
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
        $sticky = $blogModel->getAllstickyBlog();
        $this->view->sticky = $sticky;
	$stickyHistory=$blogModel->getAllHistry();
	$this->view->history = $stickyHistory;	

    }
    public function showAction()
    {
        $this->validateAdmin();

        $blogModel = new Admin_Model_Blog();
        $blogId = $this->_request->getParam('id');

        $blog = $blogModel->getDetailForAdmin($blogId);

        if (empty($blog)) {
            $this->redirectForFailure("/admin/sticky", "Post has been deleted.");
        }

        $this->view->blog = $blog;
    }
    public function stickyAction()
    {
        $data = array();
        $this->disableLayout();

        $blogId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');

        $adminId = $authNamespace->adminData['admin_id'];

        $data['last_modarate_by'] = $adminId;

        $blogModel = new Admin_Model_Blog();
        $status = $blogModel->setStickyStatus($data,$blogId);    // setStickyPost setSkStatus

        if ($status) {
            $this->redirectForSuccess("/admin/sticky/show/id/{$blogId}", "Blog select status updated");
        } else {
            $this->redirectForFailure("/admin/sticky/show/id/{$blogId}", "Something went wrong");
        }

    }

}
