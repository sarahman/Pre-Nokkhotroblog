<?php

/**
 * Speed Base Form
 *
 * @package			Speed Library
 * @category		Form
 * @author			Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright		Copyright (c) 2011 Right Brain Solution Ltd. <http://rightbrainsolution.com>
 */
class Speed_Form_Base extends Zend_Form
{
    protected $formElements = array();

    protected function initializeForm($options = array())
    {
        if (!empty($options['name'])) {
            $this->setName($options['name']);
            $this->setAttrib('id', empty($options['id']) ? $options['name'] : $options['id']);
        }

        empty($options['class']) || $this->setAttrib('class', $options['class']);

        if (empty ($options['isEdit']) && !empty ($options['addLink'])) {
            $this->setAction($options['addLink']);
        } else if (!empty ($options['editLink'])) {
            $this->setAction($options['editLink']);
        } else if (!empty ($options['link'])) {
            $this->setAction($options['link']);
        }
    }

    protected function finalizeForm()
    {
        foreach ($this->formElements AS $element) {
            $this->addElement($element);
        }
    }

    protected function addHiddenElement($name, $value = null)
    {
        $field = new Zend_Form_Element_Hidden($name);

        empty($value) || $field->setValue($value);

        $this->formElements[$name] = $field;
    }

    protected function addTextElement(array $options)
    {
        $field = new Zend_Form_Element_Text($options['name']);

        $field->setLabel($options['label'])
              ->addFilter('StringTrim')
              ->addFilter('StripTags')
              ->addFilter('HtmlEntities');

        empty($options['class']) || $field->setAttrib('class', $options['class']);
        empty($options['messageForRequired']) || $this->setElementRequired($field, $options['messageForRequired']);

        $this->formElements[$options['name']] = $field;
        return $field;
    }

    protected function addNumberTextElement(array $options)
    {
        $field = $this->addTextElement($options);

        $field->addValidator('Digits', true, array('messages' => "{$options['label']} must be a number."));

        $this->formElements[$options['name']] = $field;
        return $field;
    }

    protected function addDecimalTextElement(array $options)
    {
        $field = $this->addTextElement($options);

        $field->addValidator('Float', true, array('messages' => "{$options['label']} must be a decimal number."));

        $this->formElements[$options['name']] = $field;
        return $field;
    }

    protected function addEmailAddressElement(array $options)
    {
        $field = $this->addTextElement($options);

        $field->addValidator('EmailAddress');

        $this->formElements[$options['name']] = $field;
        return $field;
    }

    protected function addPasswordElement(array $options)
    {
        $field = new Zend_Form_Element_Password($options['name']);

        $field->setLabel($options['label'])
              ->addFilter('StringTrim');

        empty($options['class']) || $field->setAttrib('class', $options['class']);
        empty($options['messageForRequired']) || $this->setElementRequired($field, $options['messageForRequired']);

        $field->addValidator('StringLength', true, array('min' => 6, 'max' => 32));
        $this->formElements[$options['name']] = $field;
        return $field;
    }

    protected function addTextAreaElement(array $options)
    {

        $field = new Zend_Form_Element_Textarea($options['name']);

        $field->setLabel($options['label']);

        empty($options['class']) || $field->setAttrib('class', $options['class']);
        empty($options['cols']) || $field->setAttrib('cols',$options['cols']);
        empty($options['rows']) || $field->setAttrib('rows',$options['rows']);
        empty($options['attributes']) || $field->setAttribs($options['attributes']);


        $this->formElements[$options['name']] = $field;
        return $field;
    }

    protected function addSubmitButtonElement($options = array())
    {
        if (empty($options['name'])) {
            $name = empty($options['isEdit']) ? 'add' : 'update';
        } else {
            $name = $options['name'];
        }

        $field = new Zend_Form_Element_Submit($name);

        $field->setIgnore(true)
              ->setLabel(ucwords($name))
              ->setAttrib('class', 'btn-primary')
              ->removeDecorator('label');

        empty($options['id']) || $field->setAttrib('id', $options['id']);
        empty($options['class']) || $field->setAttrib('class', $options['class']);

        $this->formElements[$name] = $field;
        return $field;
    }

    protected function addRedirectingCancelButtonElement($options = array())
    {
        $name = empty($options['name']) ? 'cancel' : $options['name'];
        $field = new Zend_Form_Element_Button($name);

        $field->setLabel(ucfirst($name));

        if (empty ($options['redirectLink'])) {
            $field->setAttrib('onClick', 'javascript:history.go(-1); return false;');
        } else {
            $field->setAttrib('onClick', 'window.location="' . $options['redirectLink'] . '"; return false;');
        }

        empty($options['class']) || $field->setAttrib('class', $options['class']);

        $this->formElements[$name] = $field;
        return $field;
    }

    protected function addCancelButtonElement()
    {
        $name = 'cancel';
        $field = new Zend_Form_Element_Button($name);

        $field->setLabel(ucfirst($name))
              ->setAttrib('id', 'cancel-button')
              ->setAttrib('class', 'btn')
              ->removeDecorator('label');

        empty($options['class']) || $field->setAttrib('class', $options['class']);

        $this->formElements[$name] = $field;
        return $field;
    }

    protected function setElementRequired(Zend_Form_Element $element, $errorMsg)
    {
        $element->setRequired(true)
                ->addDecorator('Label', $this->getOptionsForReqLabel($element))
                ->addValidator('NotEmpty', true, array('messages' => $errorMsg));

        return $this;
    }

    protected function getOptionsForReqLabel(Zend_Form_Element $element)
    {
        $options = $element->getDecorator('Label')->getOptions();

        $options['escape']         = false;
        $options['requiredSuffix'] = '<sup>*</sup>';

        return $options;
    }
}