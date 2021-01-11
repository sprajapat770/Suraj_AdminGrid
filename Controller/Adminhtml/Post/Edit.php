<?php
namespace Suraj\AdminGrid\Controller\Adminhtml\Post;

use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /*$resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $resultPage;*/
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Suraj_AdminGrid::post');
        $resultPage->getConfig()->getTitle()->prepend(__('New Entry'));

        return $resultPage;
    }
}