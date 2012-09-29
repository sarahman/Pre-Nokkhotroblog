<?php
/**
 * URL Helper
 *
 * @category   Utility
 * @author     Sirajus Salayhin <salayhin@gmail.com>
 */

class Speed_Utility_Url
{
//    function getUrl($str, $separator = 'dash', $lowercase = FALSE)
//	{
//		if ($separator === 'dash')
//		{
//			$search		= '_';
//			$replace	= '-';
//		}
//		else
//		{
//			$search		= '-';
//			$replace	= '_';
//		}
//
//		$trans = array(
//						'&\#\d+?;'				=> '',
//						'&\S+?;'				=> '',
//						'\s+'					=> $replace,
//						'[^a-z0-9\-\._]'		=> '',
//						$replace.'+'			=> $replace,
//						$replace.'$'			=> $replace,
//						'^'.$replace			=> $replace,
//						'\.+$'					=> ''
//					);
//
//		$str = strip_tags($str);
//		foreach ($trans as $key => $val)
//		{
//			$str = preg_replace('#'.$key.'#i', $val, $str);
//		}
//
//		if ($lowercase === TRUE)
//		{
//			$str = strtolower($str);
//		}
//
//		return trim(trim(stripslashes($str)), $replace);
//	}


    public  function getUrl($str, $replace = array(), $delimiter = '-')
    {
        if (!empty($replace)) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

}