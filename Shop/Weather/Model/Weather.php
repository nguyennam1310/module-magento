<?php


namespace Shop\Weather\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Weather extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'shop_weather_weather';

    protected $_cacheTag = 'shop_weather_weather';

    protected $_eventPrefix = 'shop_weather_weather';

    protected function _construct()
    {
        $this->_init('Shop\Weather\Model\ResourceModel\Weather');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}