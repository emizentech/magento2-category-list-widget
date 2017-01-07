<?php
namespace Emizentech\CategoryWidget\Block\Widget;

class CategoryWidget extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    protected $_template = 'widget/categorywidget.phtml';
    
    /**
    * Default value for products count that will be shown
    */
    const DEFAULT_IMAGE_WIDTH = 250;
    const DEFAULT_IMAGE_HEIGHT = 250;
    protected $_categoryHelper;
    protected $categoryFlatConfig;
    
    protected $topMenu;
    protected $_categoryFactory;
    
    /**
    * @param \Magento\Framework\View\Element\Template\Context $context
    * @param \Magento\Catalog\Helper\Category $categoryHelper
    * @param array $data
    */
    public function __construct(
    
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Catalog\Helper\Category $categoryHelper,
    \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
    \Magento\Catalog\Model\CategoryFactory $categoryFactory,
    \Magento\Theme\Block\Html\Topmenu $topMenu
    ) {
        $this->_categoryHelper = $categoryHelper;
        $this->categoryFlatConfig = $categoryFlatState;
        $this->topMenu = $topMenu;
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    /**
    * Return categories helper
    */
    public function getCategoryHelper()
    {
        return $this->_categoryHelper;
    }
    
    public function getCategoryModel($id)
    {
        $_category = $this->_categoryFactory->create();
        $_category->load($id);
        return $_category;
    }

    /**
    * Retrieve current store categories
    *
    * @param bool|string $sorted
    * @param bool $asCollection
    * @param bool $toLoad
    * @return \Magento\Framework\Data\Tree\Node\Collection|\Magento\Catalog\Model\Resource\Category\Collection|array
    */
    public function getCategoryCollection()
    {
        $category = $this->_categoryFactory->create();
        if($this->getData('parentcat') > 0){
            $rootCat = $this->getData('parentcat');
            $category->load($rootCat);
        }
        
        if(!$category->getId()){
            $rootCat = $this->_storeManager->getStore()->getRootCategoryId();
            $category->load($rootCat);
        }
        $storecats = $category->getChildrenCategories();
        $storecats->addAttributeToSelect('image');
        return $storecats;
        // $catCollection = $this->_categoryHelper->getStoreCategories($sorted , $asCollection, $toLoad);
        // return $catCollection;
    }
    
    /**
    * Retrieve child store categories
    *
    */
    public function getChildCategories($category)
    {
        if ($this->categoryFlatConfig->isFlatEnabled() && $category->getUseFlatResource()) {
            $subcategories = (array)$category->getChildrenNodes();
        } else {
            $subcategories = $category->getChildren();
        }
        return $subcategories;
    }
    
    /**
    * Get the widht of product image
    * @return int
    */
    public function getImageWidth() {
        if($this->getData('imagewidth')==''){
            return DEFAULT_IMAGE_WIDTH;
        }
        return (int) $this->getData('imagewidth');
    }

    /**
    * Get the height of product image
    * @return int
    */
    public function getImageHeight() {
        if($this->getData('imageheight')==''){
            return DEFAULT_IMAGE_HEIGHT;
        }
        return (int) $this->getData('imageheight');
    }
    
    public function canShowImage(){
        if($this->getData('image') == 'image')
        return true;
        elseif($this->getData('image') == 'no-image')
            return false;
    }
}