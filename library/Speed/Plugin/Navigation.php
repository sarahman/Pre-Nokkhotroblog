<?php

class Speed_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
                // Get the view, we'll need to assign the navigation to it later
            $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
            if (null === $viewRenderer->view) $viewRenderer->initView();
            $view = $viewRenderer->view;

                // Create a new Navigation Object
            $container = new Zend_Navigation();

                // Create the pages
            $pages = array(
                array(
                    'label' => 'Home',
                    'uri' => '/',
                    'pages' => array(),
                ),
                array(
                    'label' => 'Page 2',
                    'uri' => '/page-2',
                    'pages' => array(),
                ),
                array(
                    'label' => 'Page 3',
                    'uri' => '/page-3',
                    'pages' => array(),
                ),
            );

                // Set the pages to the navigation container
            $container->setPages($pages);

                // Set the active page
            $activePage = $container->findByUri($request->getRequestUri());
            $activePage->active = true;

                // Assign the navigation to the view
            $view->navigation($container);
        }

}
