<?php
/**
 * Notice Model
 *
 * @Notice        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_Model_Mygroup extends Speed_Model_Abstract
{

    /**
    * @var Admin_Model_Dao_Notic
    */
    protected $dao;

    public function __construct($dao = null)
       {
           if (empty ($dao)) {
               $this->dao = new User_Model_Dao_Mygroup();

           } else {
               $this->dao = $dao;
       }
    }



    public function getAll()
      {
        return $this->dao->getAll();

      }

    public function getDetailForGroup($detailId)
    {
        if (empty ($detailId)) {
            return false;
        }

        $record = $this->dao->getDetailForGroup($detailId);

        return $record;
    }

public function setPublishStatus($data, $detailId)
    {
        if (empty($data) AND (empty($detailId))) {
            return false;
        }


        $status = $this->getPublishStatus($detailId);

        if ($status['is_active'] == 1) {

            $data['is_active'] = 0;
        } else {
            $data['is_active'] = 1;
        }

        $this->dao->modify($data, $detailId);

        return true;
    }

    public function getPublishStatus($detailId)
    {
        if (empty($detailId)) {
            return false;
        }

        return $this->dao->getPublishStatus($detailId);
    }

    public function delete($detailId = null)
    {
        if (empty($detailId)) {
            return false;
        }

        return $this->dao->remove($detailId);
    }








}
