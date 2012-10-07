<?php

class Speed_View_Helper_FlashMessenger extends Zend_View_Helper_Abstract
{
    /**
     * @var Zend_Controller_Action_Helper_FlashMessenger
     */
    private $_flashMessenger = null;

    /**
     * Display Flash Messages.
     * 
     * @param string $key Message level for string messages
     * @return string Flash messages formatted for output
     */
    public function flashMessenger($key = 'warning')
    {
        $flashMessenger = $this->_getFlashMessenger();

        $messages = $flashMessenger->getMessages();

        if ($flashMessenger->hasCurrentMessages()) {
            $messages = array_merge(
                $messages,
                $flashMessenger->getCurrentMessages()
            );
            $flashMessenger->clearCurrentMessages();
        }

        $output ='';

        foreach ($messages as $message)
        {
            if (is_array($message)) {
                list($key,$message) = each($message);
            }
            $output .= sprintf($this->_getTemplate(),$key,$message);
        }

        return $output;
    }

    /**
     * Lazily fetches FlashMessenger Instance.
     * 
     * @return null|Zend_Controller_Action_Helper_FlashMessenger
     */
    public function _getFlashMessenger()
    {
        if (null === $this->_flashMessenger) {
            $this->_flashMessenger =
                Zend_Controller_Action_HelperBroker::getStaticHelper(
                    'FlashMessenger');
        }
        return $this->_flashMessenger;
    }

    private function _getTemplate()
    {
        return <<<Speed

            <div class="%s fade-in alert-block">
                <a class="close" data-dismiss="alert" href="#">&times;</a>
                <strong>%s</strong>
            </div>
Speed;
    }
}
