<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Suraj\AdminGrid\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;

use Suraj\AdminGrid\Model\Post;
use Suraj\AdminGrid\Model\PostFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var PostFactory
     */
    private $postFactory;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        PostFactory $postFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->postFactory = $postFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(PostFactory::class);
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('post_id');

            $model = $this->_objectManager->create(\Suraj\AdminGrid\Model\Post::class);
            // if (!$model->getId() && $id) {
            //     $this->messageManager->addErrorMessage(__('This Blog no longer exists.'));
            //     return $resultRedirect->setPath('*/*/');
            // }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Post.'));
                $this->dataPersistor->clear('new_post');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Blog.'));
            }

            $this->dataPersistor->set('new_post', $data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $this->getRequest()->getParam('post_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
