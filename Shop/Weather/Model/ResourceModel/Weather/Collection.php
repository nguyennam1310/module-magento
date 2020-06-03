<?php


namespace Shop\Weather\Model\ResourceModel\Weather;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'shop_weather_weather_collection';
    protected $_eventObject = 'weather_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Shop\Weather\Model\Weather', 'Shop\Weather\Model\ResourceModel\Weather');
    }

}