<?php
/**
 * URL Helper
 *
 * @category   Utility
 * @author     Sirajus Salayhin <salayhin@gmail.com>
 */



class Security
{
    public static function hash($string, $salt)
    {
        return sha1($string . $salt);
    }
}
