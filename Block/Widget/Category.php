<?php

namespace Emizentech\CategoryWidget\Block\Widget;

class Category extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    protected $_template = 'widget/categorywidget.phtml';

    const DEFAULT_IMAGE_WIDTH = 250;
    const DEFAULT_IMAGE_HEIGHT = 250;

    /**
     * \Magento\Catalog\Model\CategoryFactory $categoryFactory
     */
    protected $_categoryFactory;
    protected $_urlInterface;
    protected $_registry;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Registry $registry
    )
    {
        $this->_categoryFactory = $categoryFactory;
        $this->_registry = $registry;

        parent::__construct($context);
    }

    /**
     * Retrieve current store categories
     *
     * @return \Magento\Framework\Data\Tree\Node\Collection|\Magento\Catalog\Model\Resource\Category\Collection|array
     */
    public function getCategoryCollection()
    {
        $category = $this->_categoryFactory->create();

        $rootCatID = NULL;
        if ($this->getData('parentcat') > 0) {
            $rootCatID = $this->getData('parentcat');
        } else {
            $currentCategoryId = $this->getCurrentCategoryId();
            $currentCategory = $this->getCategory($currentCategoryId);
            $parentCategory = $currentCategory->getParentCategory();
            if ($parentCategory) {
                $rootCatID = $parentCategory->getId();
            } else {
                $rootCatID = $this->_storeManager->getStore()->getRootCategoryId();
            }
        }

        $category->load($rootCatID);
        $childCategories = $category->getChildrenCategories()->addAttributeToSelect('image');
        return $childCategories;
    }

    /**
     * Get the width of product image
     * @return int
     */
    public function getImageWidth()
    {
        if ($this->getData('imagewidth') == '') {
            return DEFAULT_IMAGE_WIDTH;
        }
        return (int)$this->getData('imagewidth');
    }

    /**
     * Get the height of product image
     * @return int
     */
    public function getImageHeight()
    {
        if ($this->getData('imageheight') == '') {
            return DEFAULT_IMAGE_HEIGHT;
        }
        return (int)$this->getData('imageheight');
    }

    public function canShowImage()
    {
        if ($this->getData('image') == 'image')
            return true;
        elseif ($this->getData('image') == 'no-image')
            return false;
    }

    public function getPreviousCategory()
    {
        $catId = $this->getPreviousCategoryId();
        return $this->getCategory($catId);
    }

    public function getNextCategory()
    {
        $catId = $this->getNextCategoryId();
        return $this->getCategory($catId);
    }

    private function getCategory($catId)
    {
        if ($catId) {
            $category = $this->_categoryFactory->create();
            $category->load($catId);

            return $category;
        }
        return null;
    }

    private function getPreviousCategoryId()
    {
        return $this->prevnextCategory('previous');
    }

    private function getNextCategoryId()
    {
        return $this->prevnextCategory('next');
    }

    private function prevnextCategory($direction)
    {
        $currentCategoryId = $this->getCurrentCategoryId();
        if ($currentCategoryId) {
            $categories = $this->getCategoryCollection();
            $categoriesIds = $categories->getAllIds();
            $countCategories = count($categoriesIds);
            if ($currentCategoryId && !empty($categoriesIds)) {
                $currentIndex = array_search($currentCategoryId, $categoriesIds);
                if (!is_null($currentIndex)) {
                    if ($direction === 'previous') {
                        $targetIndex = --$currentIndex;
                        if ($targetIndex < 0) {
                            $targetIndex = $countCategories - 1;//loop
                        }
                    } elseif ($direction === 'next') {
                        $targetIndex = ++$currentIndex;
                        if ($targetIndex >= $countCategories) {
                            $targetIndex = 0;//loop
                        }
                    }
                    return $categoriesIds[$targetIndex];
                }
            }
        }

        return null;
    }

    private function getCurrentCategoryId()
    {
        $category = $this->_registry->registry('current_category');
        if ($category) {
            return $category->getId();
        }
        return 0;
    }
}
