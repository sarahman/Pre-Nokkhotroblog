<?php

/**
 * Image Helper
 * @category   Utility
 * @author     Sirajus Salayhin <salayhin@gmail.com>
 */

class Speed_View_Helper_Image
{
    public function extract($text)
    {
        $html = $text;
        $html .= "alt='...' title='...' />";

        $pattern = '/<img[^>]+src[\\s=\'"]';
        $pattern .= '+([^"\'>\\s]+)/is';

        if (preg_match(
            $pattern,
            $html,
            $match)
        ) {
            return $match[1];
        } else {
            return false;
        }
    }

    public function removeImageTag($text)
    {
        return preg_replace("/<img[^>]+\>/i", "", $text);
    }
}

