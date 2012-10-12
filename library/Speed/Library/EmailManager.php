<?php

/**
 * EmailManager Library
 * @category   Library
 * @copyright  Copyright (c) 2011 Right Brain Solution Ltd. http://rightbrainsolution.com
 * @author     Eftakhairul Islam <eftakhairul@gmail.com>
 */

class Speed_Library_EmailManager
{
    /**
     * @var Zend_Mail_Transport_Abstract
     */
    protected $transport;
    /**
     * @var Zend_Mail
     */
    protected $emailer;

    public function __construct($options = array())
    {
        if (empty($options)) {
            $options = array(
                'config' => APPLICATION_PATH . '/configs/email.ini'
            );
        }

        $config   = new Zend_Config_Ini($options['config']);
        $settings = $config->toArray();

        $this->init($settings);
    }

    private function init($settings)
    {
        $this->transport = new Zend_Mail_Transport_Smtp($settings['server'], $settings);
        $this->emailer   = new Zend_Mail();
        $this->emailer->setFrom($settings['username']);
    }

    public function send($template, $subject, $to, $toName = '', $data = array())
    {
        $body = $this->getBody($template, $data);

        $this->emailer->addTo($to, $toName);
        $this->emailer->clearSubject();
        $this->emailer->setSubject($subject);
        $this->emailer->setBodyHtml($body);
        $this->emailer->send($this->transport);
    }

    private function getBody($template, $data)
    {
        $view = new Zend_View();

        $view->setScriptPath(APPLICATION_PATH . '/templates');
        $view->assign($data);

        $body = $view->render($template . ".phtml");
        return $body;
    }
}