<?php


namespace Shop\Weather\Block;

use Magento\Framework\View\Element\Template;
use Shop\Weather\Model\WeatherFactory;

class Weather extends Template
{
    private $factory;

    public function __construct(
        Template\Context $context,
        WeatherFactory $factory
    )
    {
        parent::__construct($context);
        $this->factory = $factory;
    }

    public function getWeather()
    {
        $factory = $this->factory->create();
        $weather = $factory
            ->getCollection()
            ->addOrder('created_at', 'ASC')
            ->getLastItem();

        if ($weather->isEmpty()) {
            return null;
        }

        return $weather;
    }
}
