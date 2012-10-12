<?php
/**
 * Episod Controller
 * @Group Type   Controller
 * @package     Blog
 * Date Sep 24 2012
 * @author      Mohammad Zafar iqbal <zafar@speedplusnet.com>
 */
class Blog_StickysController extends Speed_Controller_ActionController
{
    public function init()
    {
        parent::init();
        $categoryModel        = new Blog_Model_BlogCategory();
        $this->view->Category = $categoryModel->getAll();
        $pageModel            = new Admin_Model_Page();
        $this->view->pages    = $pageModel->getAll();
    }

    public function indexAction()
    {
        $this->_helper->layout->setLayout('general');
        $stickyModel         = new Blog_Model_Sticky();
        $display             = $stickyModel->getAll();
        $this->view->display = $display;
    }

    public function showAction()
    {
        //$this->validateUser();
        $this->_helper->layout->setLayout('general');
        $stickyModel   = new Blog_Model_Sticky();
        $stickyId      = $this->_request->getParam('id');
        $stickydisplay = $stickyModel->getDetailForAdmin($stickyId);
        if (empty($stickydisplay)) {
            $this->redirectForFailure("/blog/stickys/index", "No Stickys has been found.");
        }
        $this->view->stickydisplay = $stickydisplay;
    }
}
