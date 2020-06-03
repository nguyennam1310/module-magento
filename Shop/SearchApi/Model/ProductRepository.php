<?php
namespace Shop\SearchApi\Model;

use Shop\SearchApi\Api\ConfigurableProductRepositoryInterface;
use Shop\SearchApi\Api\ProductRepositoryInterface;
use Shop\SearchApi\Api\Data\ProductInterfaceFactory;
use Shop\SearchApi\Helper\ProductHelper;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 *
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var ProductInterfaceFactory
     */
	private $productInterfaceFactory;
    /**
     * @var ProductHelper
     */
	private $productHelper;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
	private $productRepository;

	/**
* ProductRepository constructor.
* @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
* @param ProductInterfaceFactory $productInterfaceFactory
* @param ProductHelper $productHelper
 */

	public function __construct(
		\Magento\Catalog\Api\ProductRepositoryInterface $productRepository, ProductInterfaceFactory $productInterfaceFactory,
		ProductHelper $productHelper
	)
	{
		$this->productInterfaceFactory=$productInterfaceFactory;
		$this->productHelper= $productHelper;
		$this->productRepository= $productRepository;
	}

	/**
     * @param int $id
     * @return \Shop\SearchApi\Api\Data\ProductInterface
     * @throws NoSuchEntityException
     */
	public function getProductById($id)
	{
	    /** @var \Shop\SearchApi\Api\Data\ProductInterface $productInterface */
		$productInterface = $this->productInterfaceFactory->create();
		try {
		    /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
			$product = $this->productRepository->getById($id);
			$productInterface->setId($product->getId());
			$productInterface->setSku($product->getSku());
			$productInterface->setName($product->getName());
			$productInterface->setDescription( $product->getDescription() ? $product->getDescription():"" );
			$productInterface->setPrice($this->productHelper->formatPrice($product->getPrice()));
			$productInterface->setImages($this->productHelper->getProductImagesArray($product));
			return $productInterface;
		}catch (NoSuchEntityException $e) {
			throw NoSuchEntityException::singleField('id',$id);


		}
	}
}
?>
