<?php
namespace CSSoft\ContentSheduler\Model;

use Magento\Framework\Model\AbstractModel;
use CSSoft\ContentSheduler\Api\Data\ProductScheduleInterface;

class ProductSchedule extends AbstractModel implements ProductScheduleInterface
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(\CSSoft\ContentSheduler\Model\ResourceModel\ProductSchedule::class);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Get Scheduled Entity ID
     *
     * @return int
     */
    public function getScheduledEntityId()
    {
        return $this->getData(self::SCHEDULED_ENTITY_ID);
    }

    /**
     * Get Product IDs
     *
     * @return string
     */
    public function getProductIds()
    {
        return $this->getData(self::PRODUCT_IDS);
    }

    /**
     * Get Product Attribute
     *
     * @return string
     */
    public function getProductAttribute()
    {
        return $this->getData(self::PRODUCT_ATTRIBUTE);
    }

    /**
     * Set ID
     *
     * @param int $entityId
     * @return $this
     */
    public function setId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Set Scheduled Entity ID
     *
     * @param int $scheduledEntityId
     * @return $this
     */
    public function setScheduledEntityId($scheduledEntityId)
    {
        return $this->setData(self::SCHEDULED_ENTITY_ID, $scheduledEntityId);
    }

    /**
     * Set Product IDs
     *
     * @param string $productIds
     * @return $this
     */
    public function setProductIds($productIds)
    {
        return $this->setData(self::PRODUCT_IDS, $productIds);
    }

    /**
     * Set Product Attribute
     *
     * @param string $productAttribute
     * @return $this
     */
    public function setProductAttribute($productAttribute)
    {
        return $this->setData(self::PRODUCT_ATTRIBUTE, $productAttribute);
    }

    
   
}