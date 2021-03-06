<?php
/**
 * Discussion Type Entry Form
 * @category        Form
 * @package         Discussion Type
 * @author          Mohammad Zafar Iqbal <zafar@speedplusnet.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Form_Episode extends Speed_Form_Base
{
    public function __construct($options = array())
    {
        parent::__construct();
        $isEdit = empty($options['isEdit']) ? false : true;
        $this->initForm();
        $this->addNovelNameField($options['episode_name']);
        $this->addTitleField($isEdit);
        $this->addBlogstatusField($options['status']);
        $this->addNovelField($isEdit);
        $this->addSubmitButtonField($isEdit);
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

    protected function addNovelNameField($role)
    {
        $options = new Zend_Form_Element_Select('episode_id');
        foreach ($role AS $value) {
            $options->addMultiOptions(array($value['episode_id'] => $value['episode_name']));
        }
        $options->setAttrib('class', 'span10')
            ->setAttrib('episode_id', 'episode_name')
            ->setLabel('Episod Name');
        $this->formElements['episode_id'] = $options;
    }

    protected function addTitleField()
    {
        $options = array(
            'name' => 'episode_number',
            'label' => 'Episode Number',
            'class' => 'span10',
            'messageForRequired' => "Please enter the Episode Type."
        );
        $this->addTextElement($options);
    }

    protected function addBlogstatusField($blogStatus)
    {
        $field = new Zend_Form_Element_Select('status');
        foreach ($blogStatus AS $value) {
            $field->addMultiOptions(array($value['status'] => $value['status']));
        }
        $field->setAttrib('class', 'span6')
            ->setAttrib('id', 'status')
            ->setLabel('Status');
        $this->formElements['status'] = $field;
    }

    protected function addNovelField()
    {
        $options = array(
            'name' => 'description',
            'label' => 'Description: ',
            'class' => 'span10',
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
                                                     'redirectLink' => '/blog/episods/index'
                                                 ));
    }
}

