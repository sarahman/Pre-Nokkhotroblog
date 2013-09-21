<?php
/**
 * Episods Controller
 * Discussion   Controller
 * @package     Discussion
 * @author      Mustafa Ahmed Khan <tamal_29@yahoo.com>
 */
class Admin_EpisodsController extends Speed_Controller_ActionController
{
    protected function initialize()
    {
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $episodModel         = new Admin_Model_Episod();
        $display             = $episodModel->getAll();
        $this->view->display = $display;
    }

    public function deleteAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $episodModel = new Admin_Model_Episod();
        $episodId    = $this->_request->getParam('id');
        $status      = $episodModel->delete($episodId);
        if ($status) {
            $this->redirectForSuccess("/admin/episods", "Episod deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/episods", "Something went wrong. Please try again");
        }
    }

    public function showAction()
    {
        $this->validateAdmin();
        $this->_helper->layout->setLayout('admin');
        $episodModel = new Admin_Model_Episod();
        $episodId    = $this->_request->getParam('id');
        $episod      = $episodModel->getDetailForEpisod($episodId);
        if (empty($episod)) {
            $this->redirectForFailure("/admin/episods", "Episods has been deleted.");
        }
        $this->view->episod = $episod;
    }

    public function publishAction()
    {
        $data = array();
        $this->_helper->layout->setLayout('admin');
        $episodId          = $this->_request->getParam('id');
        $authNamespace     = new Zend_Session_Namespace('adminInformation');
        $adminId           = $authNamespace->adminData['admin_id'];
        $data['update_by'] = $adminId;
        $episodModel       = new Admin_Model_Episod();
        $status            = $episodModel->setPublishStatus($data, $episodId);
        if ($status) {
            $this->redirectForSuccess("/admin/episods/show/id/{$episodId}", "Episods status updated");
        } else {
            $this->redirectForFailure("/admin/episods/show/id/{$episodId}", "Something went wrong");
        }
    }
}
