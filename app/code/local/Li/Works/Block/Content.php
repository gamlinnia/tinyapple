<?php

class Li_Works_Block_Content extends Mage_Core_Block_Template
{

    protected $_collection;
    protected $pageSize = 9;
    protected $_pageVarName = 'page';

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
        $productCollection = Mage::getModel('catalog/category')->load($this->getCategoryId())
            ->getProductCollection()
            ->addFieldToFilter('type', $this->getProductTypeId($typeName))
            ->setOrder('entity_id', 'DESC')
            ->setPageSize($this->getPageSize())
            ->setCurPage($this->getPage() ? $this->getPage() : 1);
        $this->setCollection($productCollection);
        return $productCollection;
    }

    public function getCompletedProductIdArray ($typeName) {
        $productIdArray = array();
        $productCollection = Mage::getModel('catalog/category')->load($this->getCategoryId())
            ->getProductCollection()
            ->addFieldToFilter('type', $this->getProductTypeId($typeName))
            ->setOrder('entity_id', 'DESC');
        foreach ($productCollection as $product) {
            $productIdArray[] = $product->getId();
        }
        return $productIdArray;
    }

    public function getPrevCompletedProductId ($typeName, $productId) {
        $productIdArray = $this->getCompletedProductIdArray($typeName);
        $index = array_search((string)$productId, $productIdArray);
        return $productIdArray[$index - 1];
    }

    public function getNextCompletedProductId ($typeName, $productId) {
        $productIdArray = $this->getCompletedProductIdArray($typeName);
        $index = array_search((string)$productId, $productIdArray);
        return $productIdArray[$index + 1];
    }

    public function isFirstProduct ($typeName, $productId) {
        $productIdArray = $this->getCompletedProductIdArray($typeName);
        $index = array_search((string)$productId, $productIdArray);
        if ($index > 0) {
            return false;
        }
        return true;
    }

    public function isLastProduct ($typeName, $productId) {
        $productIdArray = $this->getCompletedProductIdArray($typeName);
        $index = array_search((string)$productId, $productIdArray);
        if ($index < count($productIdArray) - 1) {
            return false;
        }
        return true;
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

    public function getCollection()
    {
        return $this->_collection;
    }

    public function setCollection($collection)
    {
        $this->_collection = $collection;
        return $this;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
    }

    public function getPageVarName()
    {
        return $this->_pageVarName;
    }

    public function setPageVarName($pageVarName)
    {
        $this->_pageVarName = $pageVarName;
    }

    public function getPagerHtml()
    {
        $pagerBlock = $this->getChild('pager');

        if ($pagerBlock instanceof Varien_Object) {

//            $pagerBlock->setAvailableLimit($this->getAvailableLimit());

            $pagerBlock
//                ->setUseContainer(false)
//                ->setShowPerPage(false)
//                ->setShowAmounts(false)
//                ->setLimitVarName($this->getLimitVarName())
                ->setPageVarName($this->getPageVarName())
                ->setLimit(12)
                ->setFrameLength(Mage::getStoreConfig('design/pagination/pagination_frame'))
                ->setJump(3)
                ->setCollection($this->getCollection());

            return $pagerBlock->_toHtml();
        }

        return '';
    }


}