<?php

/**
 * Login Form
 * @category        Form
 * @copyright       Copyright (c) 2011 Right Brain Solution Ltd. http://www.rightbrainsolution.com
 * @author          Syed Abidur Rahman <aabid048@gmail.com>
 */
class User_Form_ForgotPassword extends Speed_Form_Base
{
    public function __construct()
    {
        parent::__construct();
        $this->initForm();
        $this->addEmailAddressField();
        $this->addDisplayGroup($this->formElements, 'auth');
        $this->getDisplayGroup('auth')->setLegend('Welcome here');
        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP);
    }

    public function initForm()
    {
        $options = array(
            'name' => 'login',
            'link' => '/user/auth/forget'
        );
        $this->initializeForm($options);
    }

    public function addEmailAddressField()
    {
        $options = array(
            'name' => 'email_address',
            'label' => 'Email Address',
            'class' => 'span4',
            'messageForRequired' => "Please enter email address."
        );
        $this->addEmailAddressElement($options);
    }

    public function addSubmitButtonField()
    {
        $this->addSubmitButtonElement(array('name' => 'submit'));
    }
}