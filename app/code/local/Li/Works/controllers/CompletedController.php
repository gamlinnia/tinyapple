<?php

class Li_Works_CompletedController extends Mage_Core_Controller_Front_Action
{

    public function indexAction () {
        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setTitle('小蘋果工程-作品展示');

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb('home')
                ->addCrumb('product', array(
                    'label'    => 'test',
                    'link'     => 'http://www.yahoo.com/',
                    'readonly' => true,
                ))->addCrumb('reviews', array('label' => Mage::helper('review')->__('Product Reviews')));
        }

        $this->renderLayout();
    }

    public function worksAction () {
        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setTitle('小蘋果工程-作品展示');

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock
                ->addCrumb('home', array(
                    'link' => '/'
                ))
                ->addCrumb('works', array(
                    'label'    => '作品展示',
                    'link'     => Mage::helper('homepage/data')->getControllerUrl()
                ))
                ->addCrumb('reviews', array('label' => Mage::helper('review')->__('Product Reviews')));
        }

        $this->renderLayout();
    }

}