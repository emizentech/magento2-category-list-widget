<?php
namespace Emizentech\CategoryWidget\Block\Widget;

class CategoryWidget extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    protected $_template = 'widget/categorywidget.phtml';
    protected $rootCategoryObject;
    protected $layerResolver;

    const DEFAULT_IMAGE_WIDTH = 250;
    const DEFAULT_IMAGE_HEIGHT = 250;
    
    /**
    * \Magento\Catalog\Model\CategoryFactory $categoryFactory
    */
    protected $_categoryFactory;
    
    /**
    * @param \Magento\Framework\View\Element\Template\Context $context
    * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
    * @param array $data
    */
    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Catalog\Model\CategoryFactory $categoryFactory,
    \Magento\Catalog\Model\Layer\Resolver $layerResolver
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->layerResolver = $layerResolver;

        parent::__construct($context);
    }

    /**
    * Retrieve current store categories
    *
    * @return \Magento\Framework\Data\Tree\Node\Collection|\Magento\Catalog\Model\Resource\Category\Collection|array
    */
    public function getCategoryCollection()
    {
        $category = $this->getRootCategory();
         
        $childCategories = $category->getChildrenCategories();
 
        $childCategories->addAttributeToSelect('image');
 
        return $childCategories;
    }
    
    public function getRootCategory() {
        if(isset($this->rootCategoryObject)) {
            return $this->rootCategoryObject;
        }

        if ($this->getData('parentcat') > 0) {
            $rootCatID = $this->getData('parentcat');
            
            $category = $this->_categoryFactory->create();
            $category->load($rootCatID);
        } else {
            $category = $this->getCurrentCategory();
        }

        $this->rootCategoryObject = $category;

        return $category;
    }

    public function getCurrentCategory()
    {
        return $this->layerResolver->get()->getCurrentCategory();
    }    
        
    public function getTitle() {
        if(empty($this->getData('show_header'))) {
            return false;
        }

        if($this->getData('show_header') == '0') {
            return false;
        }

        return $this->getRootCategory()->getName();
    }

    /**
    * Get the width of product image
    * @return int
    */
    public function getImageWidth() {
        if ( empty($this->getData('imagewidth')) ) {
            return self::DEFAULT_IMAGE_WIDTH;
        }
        return (int) $this->getData('imagewidth');
    }

    /**
    * Get the height of product image
    * @return int
    */
    public function getImageHeight() {
        if ( empty($this->getData('imageheight')) ) {
            return self::DEFAULT_IMAGE_WIDTH;
        }
        return (int) $this->getData('imageheight');
    }
    
    public function canShowImage(){
        if($this->getData('image') == 'image')
            return true;
        elseif($this->getData('image') == 'no-image')
            return false;
    }

    public function canShowCategoryName()
    {
        return in_array($this->getDisplayStyle(), ['no-image','image-and-text']);
    }    
}