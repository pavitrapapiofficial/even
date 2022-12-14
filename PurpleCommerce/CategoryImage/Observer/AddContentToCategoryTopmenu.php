<?php

namespace PurpleCommerce\CategoryImage\Observer;
 
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
 
/**
 * Class AddFirstCategoryImageToTopmenu
 * @package PurpleCommerce\CategoryImage
 */
class AddContentToCategoryTopmenu implements ObserverInterface
{
    /**
     * @var CategoryRepositoryInterface $categoryRepository
     */
    protected $categoryRepository;
 
    /**
     * AddFirstCategoryImageToTopmenu constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository repository
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }
 
    /**
     * @param Observer $observer Observer object
     */
    public function execute(Observer $observer)
    {
        $transport = $observer->getTransport();
        $html      = $transport->getHtml();
        $menuTree  = $transport->getMenuTree();
 
        $parentLevel = $menuTree->getLevel();
        $childLevel = $parentLevel === null ? 0 : $parentLevel + 1;
 
        $menuId = $menuTree->getId();
 
        if ($childLevel == 1 && $this->isCategory($menuId)) {
            $html .= '<li class="category_image" style=""><img src="'.$this->getCategoryImage($menuId).'"/></li>';
        }
 
        $transport->setHtml($html);
    }
 
    /**
     * Retrieves the category image for the corresponding child
     *
     * @param string $categoryId Category composed ID
     *
     * @return string
     */
    protected function getCategoryImage($categoryId)
    {
        $categoryIdElements = explode('-', $categoryId);
        $category           = $this->categoryRepository->get(end($categoryIdElements));
        $categoryName       = $category->getImageUrl();
 
        return $categoryName;
    }
 
    /**
     * Check if current menu element corresponds to a category
     *
     * @param string $menuId Menu element composed ID
     *
     * @return string
     */
    protected function isCategory($menuId)
    {
        $menuId = explode('-', $menuId);
 
        return 'category' == array_shift($menuId);
    }
}