<?php

/**
 * The application bootstrap used by Zend_Application
 * @category   Bootstrap
 * @package    Bootstrap
 * @copyright  Copyright (c) 2011 Right Brain Solution Ltd. (http://www.rightbrainsolution.com)
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Setup the autoloader
     * @return array|Zend_Application_Module_Autoloader
     */
    protected function _initAutoload()
    {
        // List of active modules
        $modules    = array(
            'Blog' => APPLICATION_PATH . '/modules/blog',
            'User' => APPLICATION_PATH . '/modules/user',
            'Admin' => APPLICATION_PATH . '/modules/admin'
        );
        $autoloader = array();
        date_default_timezone_set('Asia/Dhaka');
        foreach ($modules as $namespace => $modulePath) {
            $autoloader = new Zend_Application_Module_Autoloader(array(
                'namespace' => $namespace,
                'basePath' => $modulePath
            ));
        }
        return $autoloader;
    }

    /**
     * Setup the view
     */
    protected function _initViewSettings()
    {
        $cssFiles = array(
            'styles', 'datepicker/Aristo', 'border-radius', 'bootstrap', 'docs', 'bishalbangla', 'news_ticker'
        );
        $jsFiles  = array(
            'jquery-1.7.1.min', 'jquery.tablesorter.min', 'datepicker/jquery.ui.datepicker',
            'jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min', 'jcarousellite_1.0.1.pack',
            'custom', 'bootstrap-tab', 'jscal2', 'lang/en', 'js/application'
        , 'js/bootstrap.min', 'js/bootstrap-transition',
            'js/bootstrap-dropdown', 'js/bootstrap-scrollspy', 'js/bootstrap-button',
            'js/bootstrap-button',
            'js/bootstrap-button', 'avro.jquery'
        );
        $this->bootstrap('view');
        $this->_view = $this->getResource('view');
        // set encoding and doctype
        $this->_view->setEncoding('UTF-8');
        $this->_view->doctype('HTML5');
        // set the content type and language
        $this->_view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'en-US');
        // set css/js links and a special import for the accessibility styles
        foreach ($cssFiles AS $cssFile) {
            $this->_view->headLink()->appendStylesheet('/css/' . $cssFile . '.css');
        }
        // adding javascript and jQuery UI related files
        foreach ($jsFiles AS $jsFile) {
            $this->_view->headScript()->appendFile('/js/' . $jsFile . '.js');
        }
        $this->_view->headScript()->appendFile('/includes/ckeditor/' . 'ckeditor.js');
        // setting the site in the title
        $this->_view->headTitle('Nokkhotro Blog - Bangladeshi Blogging Platform');
        $this->_view->headTitle()->setSeparator(' - ');
        // adding helper file(s).
        $this->_view->addHelperPath('Speed/View/Helper', 'Speed_View_Helper');
        $this->_view->addHelperPath('Devnet/View/Helper', 'Devnet_View_Helper');
    }

    protected function _initRoutes()
    {
        $this->bootstrap('frontcontroller');
        $front    = Zend_Controller_Front::getInstance();
        $router   = $front->getRouter();
        $myRoutes = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'production');
        $router->addConfig($myRoutes, 'routes');
    }
}
