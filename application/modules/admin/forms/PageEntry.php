<?php
/**
 * PageEntry Form
 * @category        Form
 * @package         Admin
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Form_PageEntry extends Speed_Form_Base
{
    public function __construct($options = array())
    {
        parent::__construct();
        $isEdit = empty($options['isEdit']) ? false : true;
        $this->initForm();
        $this->addNameField($isEdit);
        $this->addContentField($isEdit);
        $this->addSubmitButtonField();
        $this->addCancelButtonField();
        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancel');
    }

    protected function initForm()
    {
        $options = array(
            'name' => 'page-form',
            'class' => 'span10'
        );
        $this->initializeForm($options);
    }

    protected function addNameField()
    {
        $options = array(
            'name' => 'page_name',
            'label' => 'Page Name: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter the page name."
        );
        $this->addTextElement($options);
    }

    protected function addContentField()
    {
        $options = array(
            'name' => 'description',
            'label' => 'Content: ',
            'class' => 'span6',
            'messageForRequired' => "Please fill up this field."
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
                                                     'redirectLink' => '/admin/pages/index'
                                                 ));
    }
}
