<?php

class Li_Works_FlowController extends Mage_Core_Controller_Front_Action
{

    public function indexAction () {
        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setTitle('作品展示');

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock
                ->addCrumb('home', array(
                    'label'    => '',
                    'link' => Mage::getBaseUrl()
                ))
                ->addCrumb('works', array(
                    'label'    => '作品展示',
                    'link'     => Mage::helper('homepage/data')->getRouterUrl()
                ))->addCrumb('reviews', array(
                    'label' => Mage::getModel('catalog/product')->load($this->getRequest()->getParam('id'))->getName()
                ));
        }

        $this->renderLayout();
    }

}