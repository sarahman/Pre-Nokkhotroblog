<?php
/**
 * Category Entry Form
 * @category        Form
 * @package         Category
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_Form_CommentEntry extends Speed_Form_Base
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
            'name' => 'comment-form',
            'class' => 'span7',
            'id' => (empty($isEdit) ? 'add' : 'edit') . '-comment-form'
        );
        $this->initializeForm($options);
    }

    protected function loadElements($options, $isEdit)
    {
        //$this->addUserIdField('user_id');
        $this->addCommentsDescriptionField();
        $this->addSubmitButtonField($isEdit);
        $this->addCancelButtonElement();
        empty($isEdit) || $this->addHiddenElement('user_id');
    }

    protected function addCommentsDescriptionField()
    {
        $options = array(
            'name' => 'comments',
            'label' => 'Enter your comments here:',
            'class' => 'span6',
            'rows' => 10,
            'cols' => 40,
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
