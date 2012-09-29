<?php
/**
 * Created by JetBrains PhpStorm.
 * User: salayhin
 * Date: 6/18/12
 * Time: 4:41 PM
 * To change this template use File | Settings | File Templates.
 */
/* This plugin is made to adjust different layouts for different modules */

class Plugins_SelectLayout extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
	$module = $request->getModuleName();
	$layout = Zend_Layout::getMvcInstance();

	$bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
	$options = $bootstrap->getOptions();
	$layoutPathTemp = $options['constants']['layoutPath'];
	$layoutPath = $layoutPathTemp.'/'.$module;

        $layout->setLayoutPath($layoutPath);
        $layout->setLayout('layout');
    }

}
