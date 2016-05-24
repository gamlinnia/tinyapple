<?php

class Li_About_Block_Content extends Mage_Core_Block_Template
{

    public  function _prepareLayout ()
    {
        $helper = Mage::helper('about');
        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbs->addCrumb('home', array('label'=>$helper->__('Home'), 'title'=>$helper->__('Go to Home Page'), 'link'=>Mage::getBaseUrl()));
            $breadcrumbs->addCrumb('about', array('label'=>$helper->__('About us'), 'title'=>$helper->__('About us')));
        }
    }

}