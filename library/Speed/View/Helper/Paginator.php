<?php

class Speed_View_Helper_Paginator extends Zend_View_Helper_Abstract
{
    public function paginator()
    {
        return $this;
    }

    public function slide($paginator, $options = array())
    {
        if ($paginator->count() <= 1) {
            return '';
        }

        //        $this->view->addScriptPath(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'order'. DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR. 'scripts');

        return $this->view->paginationControl($paginator, 'Sliding',
                                              'partials' . DIRECTORY_SEPARATOR . 'pagination.phtml',
                                              array('paginatorOptions' => $options));
    }

    public function buildLink($page, $label, $options = array(), $class = '')
    {
        $url = $options['path'];
        $str = str_replace('%d', $page, $options['itemLink']);

        /**
         * 10 is length of "javascript" (without ")
         */
        if (0 == strncasecmp($options['itemLink'], 'javascript', 10)) {
            $url = $str;
        } else {
            $url = rtrim($url, '/') . $str;
        }

        $formattedString = '<li' . (empty($class) ? '' : " class='{$class}'") . '><a href="%s"  >%s</a></li>';

        return sprintf($formattedString, $url, $label);
    }
}