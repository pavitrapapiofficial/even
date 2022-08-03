<?php
namespace PurpleCommerce\CategoryFilter\Block\Product\ProductList;
class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
    /**
     * Set collection to pager
     *
     * @param \Magento\Framework\Data\Collection $collection
     * @return $this
     */
    public function setCollection($collection) {
        $this->_collection = $collection;
        $this->_collection->setCurPage($this->getCurrentPage());

        // we need to set pagination only if passed value integer and more that 0
        $limit = (int)$this->getLimit();
        if ($limit) {
            $this->_collection->setPageSize($limit);
        }

        // switch between sort order options
        if ($this->getCurrentOrder()) {
            // create custom query for created_at option
            switch ($this->getCurrentOrder()) {
                case 'created_at':
                    if ($this->getCurrentDirection() == 'desc') {
                        $this->_collection
                            ->getSelect()
                            ->order('e.entity_id DESC');
                    } elseif ($this->getCurrentDirection() == 'asc') {
                        $this->_collection
                            ->getSelect()
                            ->order('e.entity_id ASC');           
                    }
                    break;
                default:
                    $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
                    break;
            }
        }

        // echo '<pre>';
        // var_dump($this->getCurrentOrder());
        // var_dump((string) $this->_collection->getSelect());
        // die;

        return $this;        
    }
}
