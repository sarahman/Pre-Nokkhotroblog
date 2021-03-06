<?php
/**
 * Discussion Type Entry Form
 * @category        Form
 * @package         Discussion Type
 * @author          Mohammad Zafar Iqbal <zafar@speedplusnet.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Form_DiscussionEntry extends Speed_Form_Base
{
    public function __construct($options = array())
    {
        parent::__construct();
        $isEdit = empty($options['isEdit']) ? false : true;
        $this->initForm();
        $this->addTitleField($isEdit);
        $this->addBlogstatusField($options['status']);
        $this->addDiscussioField($isEdit);
        $this->addDayField();
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

    protected function addTitleField()
    {
        $options = array(
            'name' => 'title',
            'label' => 'Title Name: ',
            'class' => 'span12',
            'messageForRequired' => "Please enter the title."
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

    protected function addDiscussioField()
    {
        $options = array(
            'name' => 'description',
            'label' => 'Discussion: ',
            'class' => 'span12',
            'messageForRequired' => "Please enter the Discussion."
        );
        $this->addTextAreaElement($options);
    }

    protected function addDayField()
    {
        $options = array(
            'name' => 'valid_day',
            'label' => 'Valid day: ',
            'class' => 'span12',
            'messageForRequired' => "Please enter the Valid day."
        );
        $this->addTextElement($options);
    }

    protected function addSubmitButtonField()
    {
        $this->addSubmitButtonElement(array('name' => 'submit'));
    }

    protected function addCancelButtonField()
    {
        $this->addRedirectingCancelButtonElement(array(
                                                     'name' => 'cancel',
                                                     'redirectLink' => '/blog/discussions/index'
                                                 ));
    }
}
