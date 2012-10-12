<?php
/**
 * Group Type Entry Form
 * @category        Form
 * @package         Group Type
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Form_BlogGroupTypesEntry extends Speed_Form_Base
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
            'name' => 'blog-group-type-form',
            'class' => 'span7',
            'id' => (empty($isEdit) ? 'add' : 'edit') . '-blog-group-type-form'
        );
        $this->initializeForm($options);
    }

    protected function loadElements($options, $isEdit)
    {
        $this->addgroupField();
        $this->addSubmitButtonField($isEdit);
        $this->addCancelButtonElement();
        empty($isEdit) || $this->addHiddenElement('blog_group_type_id');
    }

    protected function addgroupField()
    {
        $options = array(
            'name' => 'group_type',
            'label' => 'Group Type: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter the group type."
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
