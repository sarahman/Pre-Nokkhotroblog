<?php
/**
 * Post Type Entry Form
 * @category        Form
 * @package         Post Type
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Form_PostTypeEntry extends Speed_Form_Base
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
            'name' => 'post-types-form',
            'class' => 'span7',
            'id' => (empty($isEdit) ? 'add' : 'edit') . '-category-form'
        );
        $this->initializeForm($options);
    }

    protected function loadElements($options, $isEdit)
    {
        $this->addcategoryField();
        $this->addSubmitButtonField($isEdit);
        $this->addCancelButtonElement();
        empty($isEdit) || $this->addHiddenElement('post_type_id');
    }

    protected function addcategoryField()
    {
        $options = array(
            'name' => 'post_type',
            'label' => 'Post Type: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter the post type."
        );
        $this->addTextElement($options);
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
