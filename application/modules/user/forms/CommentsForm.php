<?php

/**
 * Comments Form
 * @category        Form
 * @copyright       Copyright (c) 2011 Right Brain Solution Ltd. http://www.rightbrainsolution.com
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class User_Form_CommentsForm extends Speed_Form_Base
{
    public function __construct($options = array())
    {
        parent::__construct();
        $isEdit = empty($options['isEdit']) ? false : true;
        $this->initForm($isEdit);
        $this->loadElements($options, $isEdit);
        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP,
                                                 empty($isEdit) ? 'add' : 'update');
    }

    protected function initForm($isEdit = false)
    {
        $options = array(
            'name' => 'comments-form',
            'class' => 'span12',
            'id' => (empty($isEdit) ? 'add' : 'edit') . '-comments-form',
            'action' => '/blog/users/comment'
        );
        $this->initializeForm($options);
    }

    protected function loadElements($options, $isEdit)
    {
        $this->addCommentsDescriptionField();
        $this->addSubmitButtonField($isEdit);
        $this->addCancelButtonElement();
        empty($isEdit) || $this->addHiddenElement('blog_id');
    }

    protected function addCommentsDescriptionField()
    {
        $options = array(
            'name' => 'comments',
            'label' => 'Enter your comments here:',
            'class' => 'span10',
            'rows' => 10,
            'cols' => 20,
            'messageForRequired' => "Please enter comments."
        );
        $this->addTextAreaElement($options);
    }

    protected function addSubmitButtonField($isEdit = null)
    {
        $name = empty($isEdit) ? 'add' : 'update';
        $this->addSubmitButtonElement(array(
                                          'name' => $name,
                                          'id' => $name . '-button'
                                      ));
    }
}
