<?php
namespace Hedeya\MobileApi\Model\Category;

class DataProvider extends \Magento\Catalog\Model\Category\DataProvider
{


	protected function getFieldsMap()
	{
    	$fields = parent::getFieldsMap();
    	if(empty($fields['mapi_category']))
    	    $fields['mapi_category'] = [];
    	    
        $fields['mapi_category'][] = 'mapi_category_image'; 
        $fields['mapi_category'][] = 'mapi_category_icon'; 
    	
    	return $fields;
	}
}