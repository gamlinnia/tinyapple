<?php

class Li_Homepage_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getAttributeOptions ($nameOrId, $value) {
        /*$nameOrId = 'attributeName' or 'attributeId'*/
        switch ($nameOrId) {
            case 'attributeName' :
                $attributeCode = $value;
                $attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', $value);
                break;
            case 'attributeId' :
                $attributeCode = Mage::getModel('eav/entity_attribute')->load($value)->getAttributeCode();
                $attributeId = $value;
                break;
        }

        if (isset($attributeCode)) {
            $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
            $attributeData = $attribute->getData();
            $rs = array(
                'attributeCode' => $attributeCode,
                'attributeId' => $attributeId
            );
            if (isset($attributeData['frontend_input'])) {
                $rs['frontend_input'] = $attributeData['frontend_input'];
            }
            if (isset($attributeData['backend_type'])) {
                $rs['backend_type'] = $attributeData['backend_type'];
            }
            if ($attribute->usesSource()) {
                $options = $attribute->getSource()->getAllOptions(false);
                $rs['options'] = $options;
            }
            return $rs;
        }

        return null;
    }

    public function getOptionValueIdFromAttributeOptionLabel ($nameOrId, $attributeNameOrAttributeId, $value) {
        $attributeInfo = $this->getAttributeOptions($nameOrId, $attributeNameOrAttributeId);
        if (count($attributeInfo['options']) > 0) {
            foreach ($attributeInfo['options'] as $optionObj) {
                if ($value == $optionObj['label']) {
                    return $optionObj['value'];
                }
            }
        }
        return null;
    }

    public function getControllerUrl () {
        return Mage::getBaseUrl() . $this->getRouterName() . DS . $this->getControllerName() . DS;
    }

    public function getRouterUrl () {
        return Mage::getBaseUrl() . $this->getRouterName() . DS;
    }

    public function getRouterName () {
        return Mage::app()->getRequest()->getRouteName();
    }

    public function getControllerName () {
        return Mage::app()->getRequest()->getControllerName();
    }

    public function getActionName () {
        return Mage::app()->getRequest()->getActionName();
    }

}