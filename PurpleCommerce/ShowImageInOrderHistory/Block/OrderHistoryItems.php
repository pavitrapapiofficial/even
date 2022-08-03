<?php

namespace PurpleCommerce\ShowImageInOrderHistory\Block;

use Magento\Framework\View\Element\Template;

class OrderHistoryItems extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \PurpleCommerce\ShowImageInOrderHistory\ViewModel\OrderHistoryItems
     */
    private $orderHistoryItemsViewModel;

    public function __construct(
        \PurpleCommerce\ShowImageInOrderHistory\ViewModel\OrderHistoryItems $orderHistoryItemsViewModel,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->orderHistoryItemsViewModel = $orderHistoryItemsViewModel;

        if (!isset($data['viewModel'])) {
            $this->setData('viewModel', $this->orderHistoryItemsViewModel);
        }
    }
}