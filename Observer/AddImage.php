<?php
namespace Harriswebworks\CategoryWidget\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddImage implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $select = $observer->getSelect();
        return $select->columns('image');
    }
}
