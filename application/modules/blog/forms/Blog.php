<?php

/**
 * Blog Form
 *
 * @category        Form
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Form_Blog extends Speed_Form_Base
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
            'name'  => 'exam-form',
            'class' => 'span4',
            'id'    => (empty($isEdit) ? 'add' : 'edit') . '-exam-form'
        );

        $this->initializeForm($options);
    }

    protected function loadElements($options, $isEdit)
    {
        $this->addNameField();
        $this->addExamTypesField($options['exam_types']);
        $this->addNoOfQuestionsField();
        $this->addConcentrationField();
        $this->addDateField();
        $this->addSubmitButtonField($isEdit);
        $this->addCancelButtonElement();
        empty($isEdit) || $this->addHiddenElement('exam_id');
    }

    protected function addCodeField()
    {
        $options = array(
            'name'                  => 'exam_code',
            'label'                 => 'Exam Code',
            'class'                 => 'span2',
            'messageForRequired'    => "Please enter exam code."
        );

        $this->addTextElement($options);
    }

    protected function addNameField()
    {
        $options = array(
            'name'                  => 'name',
            'label'                 => 'Exam Name',
            'class'                 => 'span3',
            'messageForRequired'    => "Please enter exam name."
        );

        $this->addTextElement($options);
    }

    protected function addExamTypesField($examTypes)
    {
        $field = new Zend_Form_Element_Select('exam_type');

        $field->setLabel('Exam Type');
        $field->addMultiOption('', '- Select Exam Type -');

        foreach ($examTypes AS $key => $value) {
            $field->addMultiOption($key, $value);
        }

        $this->setElementRequired($field, 'Please select an exam type.');
        $this->formElements['exam_type'] = $field;
    }

    protected function addNoOfQuestionsField()
    {
        $options = array(
            'name'                  => 'total_questions',
            'label'                 => 'Total Questions',
            'class'                 => 'span1',
            'messageForRequired'    => "Please enter no. of total questions."
        );

        $field = $this->addNumberTextElement($options);
        $field->addValidator(new Zend_Validate_GreaterThan(0));
    }

    protected function addConcentrationField()
    {
        $options = array(
            'name'                  => 'concentration',
            'label'                 => 'Concentration',
            'class'                 => 'span1',
            'messageForRequired'    => "Please enter concentration of the exam."
        );

        $field = $this->addDecimalTextElement($options);
        $field->addValidator(new Zend_Validate_GreaterThan(0));
    }

    protected function addDateField()
    {
        $options = array(
            'name'                  => 'exam_date',
            'label'                 => 'Exam Date',
            'class'                 => 'span2',
            'messageForRequired'    => "Please enter exam date."
        );

        $this->addTextElement($options);
    }

    protected function addSubmitButtonField($isEdit = null)
    {
        $name = empty($isEdit) ? 'add' : 'update';
        $this->addSubmitButtonElement(array(
           'name' => $name,
           'id'   => $name . '-button'
        ));
    }
}