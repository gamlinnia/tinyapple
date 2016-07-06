<?php

class Li_Works_CompletedController extends Mage_Core_Controller_Front_Action
{

    public function indexAction () {
        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setTitle('小蘋果工程-作品展示');

        $block=$this->getLayout()->createBlock('works/content');

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock
                ->addCrumb('home', array(
                    'label'    => '',
                    'link' => Mage::getBaseUrl()
                ))
                ->addCrumb('works', array(
                    'label'    => '作品展示',
                    'link'     => Mage::helper('homepage/data')->getRouterUrl()
                ))->addCrumb('completed', array(
                    'label' => $block->getWorkPageTitle(false)
                ));
        }



        $this->renderLayout();
    }

    public function worksAction () {
        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setTitle('小蘋果工程-作品展示');

        $block = $this->getLayout()->createBlock('works/content');

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock
                ->addCrumb('home', array(
                    'label'    => '',
                    'link' => Mage::getBaseUrl()
                ))
                ->addCrumb('works', array(
                    'label'    => '作品展示',
                    'link'     => Mage::helper('homepage/data')->getRouterUrl()
                ))
                ->addCrumb('completed', array(
                    'label' => $block->getWorkPageTitle(false),
                    'link' => Mage::helper('homepage/data')->getControllerUrl() . 'index/category_id/' . $block->getCategoryId()
                ))
                ->addCrumb('work_detail', array(
                    'label' => $block->getProduct()->getName()
                ));
        }

        $this->renderLayout();
    }

}