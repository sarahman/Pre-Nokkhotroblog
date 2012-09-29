<?php
/**
 * Discussion Type Entry Form
 *
 * @category        Form
 * @package         Discussion Type
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Form_BlogGroupPost extends Speed_Form_Base
{

    public function __construct($options = array())
    {
        parent::__construct();

        $isEdit = empty($options['isEdit']) ? false : true;

        $this->initForm();
        $this->addTitleField();
        $this->addDescriptionField($isEdit);
        $this->addSubmitButtonField();
        $this->addCancelButtonField();

        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancel');
    }

    protected function initForm()
    {
        $options = array(
            'name' => 'blog-group-post-form',
            'class' => 'span10'
        );

        $this->initializeForm($options);
    }

    protected function addTitleField()
    {
        $options = array(
            'name' => 'title',
            'label' => 'Title',
            'class' => 'span10',
            'messageForRequired' => "Please enter the Episode Type."
        );

        $this->addTextElement($options);
    }


    protected function addDescriptionField()
    {
        $options = array(
            'name' => 'description',
            'label' => 'Description: ',
            'class' => 'span12',
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
            'redirectLink' => '/live'
        ));
    }


}

