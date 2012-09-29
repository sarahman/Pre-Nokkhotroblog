<?php
/**
 * Role Entry Form
 *
 * @category        Form
 * @package         Role
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Form_RoleEntry extends Speed_Form_Base
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
            'name' => 'category-form',
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
        empty($isEdit) || $this->addHiddenElement('role_id');
    }

       protected function addcategoryField()
    {
        $options = array(
            'name' => 'role',
            'label' => 'Role: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter Role."
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
