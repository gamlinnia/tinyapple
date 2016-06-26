<?php

class Li_Homepage_Block_Content extends Mage_Core_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('li_homepage/index.phtml');
    }

}