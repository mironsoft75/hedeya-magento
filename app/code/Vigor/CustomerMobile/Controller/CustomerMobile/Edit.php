<?php
/**
 * Created By Ahmed El-Araby at 15/04/19 21:08.
 */

/**
 * Created by PhpStorm.
 * User: Ahmed El-Araby
 * Date: 15/04/2019
 * Time: 21:08
 */

namespace Vigor\CustomerMobile\Controller\CustomerMobile;


class Edit extends \Magento\Framework\App\Action\Action {

    protected $_resultPageFactory;

    public function execute(){
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

}