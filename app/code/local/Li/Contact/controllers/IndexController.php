<?php

class Li_Contact_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction () {
        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setTitle('小蘋果工程-聯絡我們');

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb('home')
            ->addCrumb('product', array(
                'label'    => 'test',
                'link'     => 'http://www.yahoo.com/',
                'readonly' => true,
            ))->addCrumb('reviews', array('label' => Mage::helper('review')->__('Product Reviews')));
        } else {
            echo 'cant load block';
        }

        $this->renderLayout();
    }

}