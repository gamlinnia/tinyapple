<?php

class Li_Works_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getWorksUrl ($work) {
        $actionName = 'works';
        return Mage::helper('homepage/data')->getControllerUrl() . $actionName . '/id/' . $this->getWorkId($work);
    }

    public function getWorkId ($work) {
        return $work->getId();
    }

}