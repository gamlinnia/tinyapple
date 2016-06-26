<?php
class Li_Homepage_Block_Html_Footer extends Mage_Core_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('li_homepage/footer.phtml');
    }

}