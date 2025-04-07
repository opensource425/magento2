<?php
namespace CSSoft\ContentSheduler\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Save extends Action
{
    /**
     * @var \CSSoft\ContentSheduler\Model\SheduleFactory
     */
    protected $sheduleFactory;

    /**
     * @var \CSSoft\ContentSheduler\Model\ProductSchedule
     */
    protected $productScheduleFactory;

    /**
     * Dependency Initilization
     *
     * @param Context $context
     * @param \CSSoft\ContentSheduler\Model\SheduleFactory $sheduleFactory
     */
    public function __construct(
        Context $context,
        \CSSoft\ContentSheduler\Model\SheduleFactory $sheduleFactory,
        \CSSoft\ContentSheduler\Model\ProductSchedule $productScheduleFactory
    ) {
        $this->sheduleFactory = $sheduleFactory;
        $this->productScheduleFactory = $productScheduleFactory;
        parent::__construct($context);
    }

    /**
     * Provides content
     *
     * @return Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();

        try {
            // Load or create the schedule model
            $sheduleModel = $this->sheduleFactory->create();
            if (isset($data['entity_id'])) {
                $sheduleModel->load($data['entity_id']);
            }

            $sheduleModel->setName($data['shedule_name'])
                ->setDescription($data['description'])
                ->setStatus('Sheduled')
                ->setStartDate($data['start_date'])
                ->setType($data['shedule_type'])
                ->setEndDate($data['end_date'])
                ->setIsActive($data['enabled'])
                ->setStore($data['stores'][0])
                ->save();

            // Prepare and convert data for product_schedule
            $productData = [
                'regular_price' => [
                    'update' => $data['update_regular_price'],
                    'action' => $data['regular_price_action'],
                    'value' => $data['regular_price_value'],
                ],
                'special_price' => [
                    'update' => $data['update_special_price'],
                    'action' => $data['special_price_action'],
                    'value' => $data['special_price_value'],
                ],
                'product_status' => [
                    'update' => $data['update_product_status'],
                    'new_status' => $data['new_status'],
                ],
                'stock_status' => [
                    'update' => $data['update_stock_status'],
                    'new_status' => $data['new_stock_status'],
                ],
                'categories' => [
                    'update' => $data['update_categories'],
                    'add' => $data['add_categories'],
                    'remove' => $data['remove_categories'],
                ],
            ];

            $productJsonData = json_encode($productData);
            // Load or create the product_schedule model
            $productScheduleModel = $this->productScheduleFactory->setScheduledEntityId($sheduleModel->getId())
                ->setProductIds($data['category_products']) // Ensure 'category_products' is correctly set in the request
                ->setProductAttribute($productJsonData)
                ->save();
            $this->messageManager->addSuccessMessage(__('The schedule and product schedule have been saved successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred while saving the data: ' . $e->getMessage()));
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $data['entity_id']]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check Autherization
     *
     * @return boolean
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('CSSoft_ContentSheduler::save');
    }
}