<?php

namespace PurpleCommerce\ShowImageInOrderHistory\ViewModel;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class OrderHistoryItems implements ArgumentInterface
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var \Magento\Framework\Data\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    private $dataObjectFactory;
    /**
     * @var \Magento\Catalog\Block\Product\ImageBuilder
     */
    private $imageBuilder;
    /**
     * @var \PurpleCommerce\ShowImageInOrderHistory\Logger
     */
    private $logger;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productCollectionFactory;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Data\CollectionFactory $collectionFactory,
        \Magento\Framework\DataObjectFactory $dataObjectFactory,
        \Magento\Catalog\Block\Product\ImageBuilder $imageBuilder,
        \PurpleCommerce\ShowImageInOrderHistory\Logger $logger
    ) {
        $this->productRepository = $productRepository;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionFactory = $collectionFactory;
        $this->dataObjectFactory = $dataObjectFactory;
        $this->imageBuilder = $imageBuilder;
        $this->logger = $logger;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function getOrderItems(\Magento\Sales\Model\Order $order, $limit)
    {
        $this->logger->addLog('getOrderItems starts');
        $productIds = [];
        $i = 0;
        $this->logger->addLog('order has some items: ' . count($order->getAllVisibleItems()));
        foreach ($order->getAllVisibleItems() as $item) {
            $i++;
            $productIds[] = $item->getProductId();
            if ($i == $limit) {
                break;
            }
        }

        return $this->getItems($productIds);
    }

    public function getItems(array $productIds)
    {
        $this->logger->addLog('order history to render : ' . implode(',', $productIds));

        $collection = $this->productCollectionFactory->create();
        $collection->addFieldToSelect('small_image');
        $collection->addUrlRewrite();
        $collection->addFieldToSelect('name');
        $collection->addIdFilter($productIds);

        $this->logger->addLog('query collection products : ' . $collection->getSelect()->__toString());
        /*$searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('entity_id', $productIds, 'in')
            ->create();*/

        //$result = $this->productRepository->getList($searchCriteria);

        //$items = $result->getItems();

        $parsedCollection = $this->collectionFactory->create();
        $this->logger->addLog('query collection result : ' . $collection->count());

        if ($collection->count() > 0) {
            foreach ($collection as $item) {
                $this->logger->addLog('build first item : ' . $item->getSku());
                $item->setImage($this->buildImage($item));
                $this->logger->addLog('order item image : ' . $item->getImage());
                $parsedCollection->addItem($item);
            }
        }

        return $parsedCollection;
    }

    private function buildImage($item)
    {
        return $this->imageBuilder->create($item, 'category_page_grid')->toHtml();
    }

    public function getImageHtml(\Magento\Catalog\Api\Data\ProductInterface $item)
    {
        return $item->getImage();
    }
}