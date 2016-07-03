<?php

class Li_Works_Block_Content extends Mage_Core_Block_Template
{

    public function getProduct () {
        return Mage::getModel('catalog/product')->load($this->getProductId());
    }

    public function getFlowProduct ($typeName, $categoryName) {
        return Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addFieldToFilter('type', $this->getProductTypeId($typeName))
            ->addFieldToFilter('name', array('like' => "%$categoryName%"))
            ->setOrder('entity_id', 'DESC')
            ->getFirstItem();
    }

    public function getCompletedProducts ($typeName) {
        return $productCollection = Mage::getModel('catalog/category')->load($this->getCategoryId())
            ->getProductCollection()
            ->addFieldToFilter('type', $this->getProductTypeId($typeName))
            ->setOrder('entity_id', 'DESC');
    }

    public function getProductTypeId ($typeName) {
        return Mage::helper('homepage/data')->getOptionValueIdFromAttributeOptionLabel('attributeName', 'type', $typeName);
    }

    public function getProductId () {
        return $this->getRequest()->getParam('id');
    }

    public function getCategoryId () {
        if ($this->getRequest()->getParam('category_id')) {
            return $this->getRequest()->getParam('category_id');
        }
        if ($productId = $this->getRequest()->getParam('id')) {
            $categoryIds = Mage::getModel('catalog/product')->load($productId)->getCategoryIds();
            return Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('level', 2)
                ->addFieldToFilter('entity_id', array('in' => $categoryIds))
                ->getFirstItem()->getId();
        }
    }

    public function getCategoryCollection () {
        return Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('level', 2)
            ->addFieldToFilter('is_active', 1);
    }

    public function getWorkPageTitle ($withSpan = true) {
        $bebug = '';
        switch (Mage::helper('homepage/data')->getControllerName()) {
            case 'index':
                return $bebug . '作品展示';
            case 'completed':
                if ($this->getCategoryId()) {
                    $title = Mage::getModel('catalog/category')->getCollection()
                        ->addAttributeToSelect('name')
                        ->addFieldToFilter('entity_id', $this->getCategoryId())
                        ->getFirstItem()->getName();
                } else {
                    $title = 'get no category id';
                }
                $subTitle = ' · 完工作品';
                if (!$withSpan) {
                    return $bebug . $title . $subTitle;
                }
                return $bebug . "<span>$title</span>" . "<span>$subTitle</span>";
            case 'flow':
                $subTitle = ' · 作業流程';
                return $bebug . '作品展示' . $subTitle;
            default:
                return 'not defined';
        }
    }

    public function getPage () {
        return $this->getRequest()->getParam('page');
    }

    public function getResizedImage($type, $imgFileName, $width, $height = null, $quality = 100) {
        $pathinfo = pathinfo($imgFileName);
        $newFileName = $pathinfo['filename'] . '_' . $width .  '.' . strtolower($pathinfo['extension']);
        switch ($type) {
            case 'category':
                $_media_dir = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'catalog' . DS . 'category' . DS;
                $cache_dir = $_media_dir . 'resize' . DS;
                $_media_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'catalog' . DS . 'category' . DS;
                $cache_url = $_media_url . 'resize' . DS;
                break;
            case 'product':
                $_media_dir = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'catalog' . DS . 'product' . DS;
                $cache_dir = $_media_dir . 'resize' . DS;
                $_media_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'catalog' . DS . 'product' . DS;
                $cache_url = $_media_url . 'resize' . DS;
                break;
        }

        if (!file_exists($cache_dir)) {
            mkdir($cache_dir);
        }

        if (!file_exists($cache_dir . $imgFileName)) {
            $_image = new Varien_Image($_media_dir . $imgFileName);
            $_image->constrainOnly(true);
            $_image->keepAspectRatio(true);
            $_image->keepFrame(false);
            $_image->keepTransparency(true);
            $_image->resize($width, $height);
            $_image->save($cache_dir . $imgFileName);
        }

        return $cache_url . $imgFileName;
    }

}