<?php
namespace {:namespace}\Controller\Adminhtml\{:class_name_upper_camel};

use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('{:table_primary_key}');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('{:namespace}\Model\{:class_name_upper_camel}');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The {:class_name_lower} has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['{:table_primary_key}' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a {:class_name_lower} to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('{:module_name}::delete');
    }
}

