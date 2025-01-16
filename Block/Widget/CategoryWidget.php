<?php
namespace Emizentech\CategoryWidget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Catalog\Model\CategoryFactory;

class CategoryWidget extends Template implements BlockInterface
{
    protected $_template = 'widget/categorywidget.phtml';

    private const DEFAULT_IMAGE_WIDTH = 250;

    private const DEFAULT_IMAGE_HEIGHT = 250;
    /**
     * @var CategoryFactory
     */

    protected CategoryFactory $categoryFactory;
    /**
     * @param Template\Context $context
     * @param CategoryFactory $categoryFactory
     * @param array $data
     */
    
    public function __construct(
        Template\Context $context,
        CategoryFactory $categoryFactory,
        array $data = []
    ) {
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve current store categories
     *
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     */
    public function getCategoryCollection()
    {
        $rootCatID = $this->getData('parentcat') ?: $this->_storeManager->getStore()->getRootCategoryId();

        $category = $this->categoryFactory->create()->load($rootCatID);
        $childCategories = $category->getChildrenCategories();
        $childCategories->addAttributeToSelect(['image', 'name', 'url_key']);
        
        return $childCategories;
    }

    /**
     * Get the width of the category image
     *
     * @return int
     */
    public function getImageWidth(): int
    {
        return $this->getData('imagewidth') ? (int) $this->getData('imagewidth') : self::DEFAULT_IMAGE_WIDTH;
    }

    /**
     * Get the height of the category image
     *
     * @return int
     */
    public function getImageHeight(): int
    {
        return $this->getData('imageheight') ? (int) $this->getData('imageheight') : self::DEFAULT_IMAGE_HEIGHT;
    }

    /**
     * Check if images can be displayed
     *
     * @return bool
     */
    public function canShowImage(): bool
    {
        return $this->getData('image') === 'image';
    }
}
