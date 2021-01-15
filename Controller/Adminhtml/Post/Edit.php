<?php
namespace Suraj\AdminGrid\Controller\Adminhtml\Post;
use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action {
        
    /**
    * @var \Magento\Framework\Registry       
    */
    private $coreRegistry;

    protected $_postFactory;
        
    /**
    * @param \Magento\Backend\App\Action\Context $context
    * @param \Magento\Framework\Registry $coreRegistry,    
    */
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Suraj\AdminGrid\Model\PostFactory $postFactory)      {
                parent::__construct($context);
                 $this->coreRegistry     = $coreRegistry;
                 $this->_postFactory = $postFactory;
            
    }
        
    /**
    * Mapped Grid List page.
    * @return \Magento\Backend\Model\View\Result\Page     
    */
    public function execute()      {
        
        $rowId = (int)$this->getRequest()->getParam('post_id');
                
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if($rowId) {
            $rowData = $this->_postFactory->create()->load($rowId);
            if(!$rowData->getId()) {
                $this->messageManager->addError(__('row data no longer exist.'));
                return $this->_redirect('suraj_admingrid/post/*');
            }
        
        $this->coreRegistry->register('post_data', $rowData);
        }
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title       = $rowId ? __('Edit Row Data ') : __('Add Row Data');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
            
    }
        protected function _isAllowed()      {
                return $this->_authorization->isAllowed('Suraj_AdminGrid::post');
            
    }
}