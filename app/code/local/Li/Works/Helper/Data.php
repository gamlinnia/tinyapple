<?php

class Li_Works_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected $actionName = 'works';

    public function getWorksUrl ($work) {
        return Mage::helper('homepage/data')->getControllerUrl() . $this->actionName . '/id/' . $this->getWorkId($work);
    }

    public function getWorkId ($work) {
        return $work->getId();
    }

}