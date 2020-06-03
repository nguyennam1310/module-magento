<?php


namespace Shop\ExchangeRate\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Rate extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'shop_rate_rate';

    protected $_cacheTag = 'shop_rate_rate';

    protected $_eventPrefix = 'shop_rate_rate';

    protected function _construct()
    {
        $this->_init('Shop\ExchangeRate\Model\ResourceModel\Rate');
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