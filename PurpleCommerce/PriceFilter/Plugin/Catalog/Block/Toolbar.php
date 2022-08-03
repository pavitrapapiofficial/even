<?php
namespace PurpleCommerce\PriceFilter\Plugin\Catalog\Block;

class Toolbar
{

    /**
    * Plugin
    *
    * @param \Magento\Catalog\Block\Product\ProductList\Toolbar $subject
    * @param \Closure $proceed
    * @param \Magento\Framework\Data\Collection $collection
    * @return \Magento\Catalog\Block\Product\ProductList\Toolbar
    */
    public function aroundSetCollection(
    \Magento\Catalog\Block\Product\ProductList\Toolbar $subject,
    \Closure $proceed,
    $collection
    ) {
    $currentOrder = $subject->getCurrentOrder();
    $result = $proceed($collection);

    if ($currentOrder) {
        if ($currentOrder == 'high_to_lowpc') {
            $subject->getCollection()->setOrder('price', 'desc');
        } elseif ($currentOrder == 'low_to_highpc') {
            $subject->getCollection()->setOrder('price', 'asc');
        }elseif ($currentOrder == "latestpc" ) {
            $dir = $subject->getCurrentDirection();
            $collection->getSelect()->order('created_at '.$dir); // you can add filter as per your requirement.
        }elseif ($currentOrder == "positionpc" ) {
            // echo "inside";
            $dir = $subject->getCurrentDirection();
            $collection->getSelect()->order('entity_id '.$dir); // you can add filter as per your requirement.
        }else{
            $dir = $subject->getCurrentDirection();
            $collection->getSelect()->order('entity_id '.$dir);
        }
    }
    // $result = $proceed($collection);
        // echo '<pre>';
        // var_dump($subject->getCurrentOrder());
        // var_dump((string) $collection->getSelect());
        // die;
    return $result;
    }
    public function aroundGetAvailableOrders(
        \Magento\Catalog\Block\Product\ProductList\Toolbar $subject,
        \Closure $proceed
    ) {
        $result = $proceed();

        //make sure that each array key does exist, and then remove them
    //    if (array_key_exists('position', $result)) unset($result['position']);
        if (array_key_exists('name', $result)) unset($result['name']);
        if (array_key_exists('price', $result)) unset($result['price']);
        // array_unshift($result,'Sort By');
        return $result;
    }

}
