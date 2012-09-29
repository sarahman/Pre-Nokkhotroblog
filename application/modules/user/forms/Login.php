<?php

/**
 * Login Form
 *
 * @category        Form
 * @copyright       Copyright (c) 2011 Right Brain Solution Ltd. http://www.rightbrainsolution.com
 * @author          Syed Abidur Rahman <aabid048@gmail.com>
 */
class User_Form_Login extends Speed_Form_Base
{
    public function __construct()
    {
        parent::__construct();

        $this->initForm();
        $this->addLoginField();
        $this->addUserPasswordField();

        $this->addDisplayGroup($this->formElements, 'auth');
        $this->getDisplayGroup('auth')->setLegend('Welcome Here');

        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP);
    }

    public function initForm()
    {
        $options = array('name' => 'login',
                         'link' => '/user/auth/login');

        $this->initializeForm($options);
    }

    public function addLoginField()
    {
        $options = array(
            'name' => 'username',
            'label' => 'Username',
            'class' => 'span3',
            'messageForRequired' => 'Please enter username.'
        );

        $this->addTextElement($options);
    }

    public function addUserPasswordField()
    {
        $options = array(
            'name' => 'password',
            'label' => 'Password',
            'class' => 'span3',
            'messageForRequired' => 'Please enter password.'
        );

        $this->addPasswordElement($options);
    }
}