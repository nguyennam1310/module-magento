<?php


namespace Shop\Weather\Cron;

use Magento\Framework\Exception\CronException;
use Magento\Framework\ObjectManagerInterface;
use Shop\Weather\Model\Weather;
use Shop\Weather\Model\ResourceModel;
use Zend\Json\Decoder;
use Zend\Json\Json;
use Psr\Log\LoggerInterface;

class Update
{
    private $objectManager;
    private $resource;

    public function __construct(
        ObjectManagerInterface $objectManager,
        ResourceModel\Weather $resource
    )
    {
        $this->objectManager = $objectManager;
        $this->resource = $resource;
    }

    public function execute()
    {
        $weather = $this->getWeatherByCity('HaNoi', 'VN');

        if (null === $weather) {
            return $this;
        }

        try {
            $this->resource->save($weather);
        } catch (\Exception $e) {
            $this->objectManager->get(LoggerInterface::class)->error($e->getMessage());
        }

        return $this;
    }

    private function getWeatherByCity(string $city, string $country): ?Weather
    {
        $uri = 'https://api.openweathermap.org/data/2.5/weather';
        $client = new \Zend\Http\Client($uri, [
            'timeout' => 5
        ]);
        $client->setParameterGet(
            [
                'appid' => 'b6f63a0d605d8dab4ee83a97d48d4fe4',
                'q' => \sprintf('%s,%s', $city, $country),
                'units' => 'metric'
            ]
        );

        try {
            $response = $client->send();
            $data = Decoder::decode($response->getBody(), Json::TYPE_ARRAY);

            if (200 !== $response->getStatusCode()) {
                $this->objectManager->get(LoggerInterface::class)->error($data['message']);
                throw new CronException($data['message']);
            }
        } catch (\Exception $e) {
            $this->objectManager->get(LoggerInterface::class)->error($e->getMessage());

            return null;
        }

        /** @var Weather $weather */
        $weather = $this->objectManager->create(Weather::class);
        $weather->setData(
            [
                'city' => $city,
                'temperature' => $data['main']['temp'],
                'pressure' => $data['main']['pressure'],
                'humidity' => $data['main']['humidity'],
                'description' =>$data['weather'][0]['description'],
                'icon'=>$data['weather'][0]['icon']
            ]
        );

        return $weather;
    }
}