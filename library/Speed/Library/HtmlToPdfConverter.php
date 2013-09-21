<?php

/**
 * HTML TO PDF Converter
 * @category   Library
 * @copyright  Right Brain Solution Ltd. (http://rightbrainsolution.com)
 * @author     Eftakhairul Islam <eftakhairul@gmail.com>
 */
require_once(APPLICATION_PATH . "/../library/Speed/Library/dompdf/dompdf_config.inc.php");
class Speed_Library_HtmlToPdfConverter
{
    private $data;
    private $pdfLocation;
    private $pdfConverter;

    public function __construct()
    {
        spl_autoload_register('DOMPDF_autoload');
        $this->pdfConverter = new DOMPDF();
        $this->data         = null;
    }

    public function setTemplate($template, $data)
    {
        $view = new Zend_View();

        $view->setScriptPath(APPLICATION_PATH . '/templates');
        $view->assign($data);
        $this->data = $view->render($template . ".phtml");

        return $this;
    }

    public function setHtml($html)
    {
        if (empty($html)) {
            return false;
        }

        $this->data = $html;
        return $this;
    }

    public function setHtmlPath($path)
    {
        if (empty($path)) {
            return false;
        }

        $this->data = file_get_contents($path);
        return $this;
    }

    public function setPdfLocation($location)
    {
        if (empty($location)) {
            return false;
        }

        $this->pdfLocation = $location;
        return $this;
    }

    public function makePdf($name)
    {
        $pdfName = empty($name) ? mt_rand(100000, 999999) : $name;

        if (empty($this->data)) {
            throw new Exception('HTML not found');
        }

        $pdfFile = $this->pdfLocation . '/' . $pdfName . '.pdf';

        $this->pdfConverter->load_html($this->data);
        $this->pdfConverter->render();
        file_put_contents($pdfFile, $this->pdfConverter->output());

        return $pdfFile;
    }

    public function downloadPdf($name)
    {
        $pdfName = empty($name) ? mt_rand(100000, 999999) : $name;

        if (empty($this->data)) {
            throw new Exception('HTML not found');
        }

        $this->pdfConverter->load_html($this->data);
        $this->pdfConverter->render();
        $this->pdfConverter->stream("{$pdfName}.pdf");
    }
}
