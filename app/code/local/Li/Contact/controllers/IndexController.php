<?php

class Li_Contact_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction () {
        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setTitle('小蘋果工程-聯絡我們');

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock
                ->addCrumb('home', array(
                    'label'    => '',
                    'link' => Mage::getBaseUrl()
                ))
                ->addCrumb('contact', array(
                'label'    => '聯絡我們'
            ));
        }

        $this->renderLayout();
    }

}