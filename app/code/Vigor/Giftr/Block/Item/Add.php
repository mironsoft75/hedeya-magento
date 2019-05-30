<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\Giftr\Block\Item;

class Add extends \Mirasvit\Giftr\Block\Item\Add
{
    public function getJsConfiguration()
    {
        $config = parent::getJsConfiguration();
        $config['Magento_Ui/js/core/app']['components']['giftr-addto__form']['config']['updatePulseUrl'] = $this->getUrl('vigor_giftr/update/index');
        return $config;
    }
}