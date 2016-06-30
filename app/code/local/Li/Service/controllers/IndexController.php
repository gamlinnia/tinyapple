<?php

class Li_Service_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction () {
        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setTitle('小蘋果工程-服務項目');

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock
                ->addCrumb('home', array(
                    'label'    => '',
                    'link' => Mage::getBaseUrl()
                ))
                ->addCrumb('service', array(
                    'label'    => '服務項目'
                ));
        }

        $this->renderLayout();
    }

}