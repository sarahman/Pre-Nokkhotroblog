<?php

class Blog_ErrorController extends Zend_Controller_Action
{
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        $logger = Zend_Registry::get('log');
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // send 404
                $this->getResponse()
                     ->setRawHeader('HTTP/1.1 404 Not Found');
                $this->view->pageHeader = 'Sorry! The requested page is not found.';
                $this->view->message = '404 page not found.';
                $logger->info($this->getRequest()->getParams());
                break;
            default:
                // application error
                $this->view->message = $errors->exception->getMessage();
                $logger->info($this->getRequest()->getParams());
                break;
        }
    }
}
