<?php

namespace Suraj\AdminGrid\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Suraj\AdminGrid\Model\ResourceModel\Post\Collection;

class InlineEdit extends Action
{

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var Collection
     */
    protected $blogCollection;

    /**
     * @param Context     $context
     * @param Collection  $blogCollection
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        Collection $blogCollection,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->blogCollection = $blogCollection;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /**
         * @var \Magento\Framework\Controller\Result\Json $resultJson
         */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postData = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postData))) {
            return $resultJson->setData(
                [
                    'messages' => [__('Please correct the data which you send.')],
                    'error' => true,
                ]
            );
        }

        try {
            $this->blogCollection
                ->setStoreId($this->getRequest()->getParam('store', 0))
                ->addFieldToFilter('post_id', ['in' => array_keys($postData)])
                ->walk('saveCollection', [$postData]);
        } catch (\Exception $e) {
            $messages[] = __('There was an error saving the data: ') . $e->getMessage();
            $error = true;
        }

        return $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error,
            ]
        );
    }
}