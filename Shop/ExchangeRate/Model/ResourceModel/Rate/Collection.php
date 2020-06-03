<?php


namespace Shop\ExchangeRate\Model\ResourceModel\Rate;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'shop_rate_rate_collection';
    protected $_eventObject = 'rate_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Shop\ExchangeRate\Model\Rate', 'Shop\ExchangeRate\Model\ResourceModel\Rate');
    }

}