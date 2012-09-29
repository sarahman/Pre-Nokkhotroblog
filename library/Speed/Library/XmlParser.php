<?php

/**
 * XML Parser Library
 *
 * @category   Library
 * @copyright  Copyright (c) 2011 Right Brain Solution Ltd. http://rightbrainsolution.com
 * @author     Eftakhairul Islam <eftakhairul@gmail.com>
 */

class Speed_Library_XmlParser
{
    private $xmlFile;
    private $folderLocation;

    public function loadFile($filePath = null)
    {
        if(empty($filePath)) {
            return false;
        }

        $this->xmlFile = $filePath;
        return $this;
    }

    public function setFolderLocation($url = null)
    {
        if(empty($url)) {
            return false;
        }

        $this->folderLocation = $url;
        return $this;
    }

    public function parseXML()
    {
        if(empty($this->xmlFile)){
            return false;
        }

        $xml     = simplexml_load_file($this->xmlFile);
        $answers = get_object_vars($xml->answers);

        $data = array(
            'exam_code'  => (string) $xml->examcode,
            'full_name'  => (string) $xml->studentname,
            'student_id' => (string) $xml->studentid,
            'answers'    => $answers
        );

        return $data;
    }

    public function parseAllFiles()
    {

        if(empty($this->folderLocation)){
            return false;
        }

        $files = scandir($this->folderLocation);
        $studentData = array();

        foreach($files AS $file)
        {
            if($file != "." OR $file != "..") {
                $studentData[] = $this->loadFile($this->folderLocation.'/'.$file)->parseXML();
            }
        }

        return $studentData;
    }

}