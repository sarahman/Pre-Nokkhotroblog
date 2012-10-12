<?php

/**
 * Abstract Model
 * @category    Model
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @author      Eftakhairul Islam <eftakhairul@gmail.com>
 * @copyright   Right Brain Solution Ltd. (http://www.rightbrainsolution.com)
 */
class Speed_Model_Abstract
{
    /**
     * @var Speed_Model_Dao_Abstract
     */
    protected $dao;
    protected $page = 1;
    protected $rowPerPage = 20;

    protected function setDao(Speed_Model_Dao_Abstract $dao)
    {
        $this->dao = $dao;
    }

    public function getSummary($options = array())
    {
        $options = $this->setCountOffset($options);
        return $this->dao->getSummary($options);
    }

    protected function setCountOffset($data = array())
    {
        if (!empty ($data['page'])) {
            $this->page = $data['page'];
        }

        $offset         = ($this->page - 1) * $this->rowPerPage;
        $data['offset'] = $offset;
        $data['total']  = $this->rowPerPage;

        return $data;
    }

    public function getTotalRows($options = array())
    {
        return $this->dao->getTotalRows($options);
    }

    public function getPaginator($resultSet, $count)
    {
        $paginator = new Zend_Paginator(new Speed_Utility_PaginatorAdapter($resultSet, $count));
        $paginator->setCurrentPageNumber($this->page);
        $paginator->setItemCountPerPage($this->rowPerPage);

        return $paginator;
    }

    public function getDetail($id = null)
    {
        if (empty ($id)) {
            return array();
        }

        return $this->dao->getDetail($id);
    }

    public function delete($id = null)
    {
        if (empty ($id)) {
            return false;
        }

        return $this->dao->remove($id);
    }
}