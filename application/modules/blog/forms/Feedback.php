<?php
/**
 * Discussion Type Entry Form
 * @category             Form
 * @package              Discussion Type
 * @author                 Mohammad Zafar Iqbal <zafar@speedplusnet.com>
 * @copyright           Copyright (c) 2012
 */
class Blog_Form_Feedback extends Speed_Form_Base
{
    public function __construct($options = array())
    {
        parent::__construct();
        $isEdit = empty($options['isEdit']) ? false : true;
        $this->initForm();
        $this->addNameField();
        $this->addEmailField($isEdit);
        $this->addPhoneNumberField();
        $this->addFeedbackField();
        $this->addSubmitButtonField();
        $this->addCancelButtonField();
        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancel');
    }

    protected function initForm()
    {
        $options = array(
            'name' => 'signup-form',
            'class' => 'span12'
        );
        $this->initializeForm($options);
    }

    protected function addNameField()
    {
        $options = array(
            'name' => 'name',
            'label' => 'Name',
            'class' => 'span10',
            'messageForRequired' => "Please enter the Episode Type."
        );
        $this->addTextElement($options);
    }

    protected function addEmailField()
    {
        $options = array(
            'name' => 'email',
            'label' => 'Email',
            'class' => 'span10',
            'messageForRequired' => "Please enter the Episode Type."
        );
        $this->addTextElement($options);
    }

    protected function addPhoneNumberField()
    {
        $options = array(
            'name' => 'phonenumber',
            'label' => 'Phone Number',
            'class' => 'span10'
        );
        $this->addTextElement($options);
    }

    protected function addFeedbackField()
    {
        $options = array(
            'name' => 'feedback',
            'label' => 'Feedback: ',
            'class' => 'span10',
            'rows' => 10,
            'cols' => 20,
            'messageForRequired' => "Please enter the Description."
        );
        $this->addTextAreaElement($options);
    }

    protected function addSubmitButtonField()
    {
        $this->addSubmitButtonElement(array('name' => 'submit'));
    }

    protected function addCancelButtonField()
    {
        $this->addRedirectingCancelButtonElement(array(
                                                     'name' => 'cancel',
                                                     'redirectLink' => '/blog/novels/index'
                                                 ));
    }
}

