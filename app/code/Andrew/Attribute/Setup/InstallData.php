<?php

declare(strict_types=1);

namespace Andrew\Attribute\Setup;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Create new EAV attribute
 *
 * @package Andrew\Attribute\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetup
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     *
     * @param EavSetup $eavSetup
     */
    public function __construct(EavSetupFactory $eavSetup)
    {
        $this->eavSetupFactory = $eavSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        /** For version compatibility */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $attributeCode = 'legasy_sku';

        /**
         * For attribute property look at \Magento\Eav\Model\Entity\Setup\PropertyMapperInterface
         *
         * 1. Eav Property Mapper - \Magento\Eav\Model\Entity\Setup\PropertyMapper - main
         * 2. Catalog Property Mapper - \Magento\Catalog\Model\ResourceModel\Setup\PropertyMapper
         * 3. Configurable Product Property Mapper -
         *      \Magento\ConfigurableProduct\Model\ResourceModel\Setup\PropertyMapper - this not used in magento 2
         */

        /**
         * 'used_in_product_listing'
         * 'used_for_promo_rules'   -     adds an attribute to a flat table
         * 'used_for_sort_by'
         */

        $entityType = ProductAttributeInterface::ENTITY_TYPE_CODE;
        $setId      = $eavSetup->getDefaultAttributeSetId($entityType);
        $groupId    = $eavSetup->getDefaultAttributeGroupId($entityType, $setId);
        /** `attribute_group_name` - it's row from table `eav_attribute_group` */
        $groupName = $eavSetup->getAttributeGroup($entityType, $setId, $groupId, 'attribute_group_name');

        $eavSetup->addAttribute(
            ProductAttributeInterface::ENTITY_TYPE_CODE,
            $attributeCode,
            [
                'label'                      => 'Legasy sku',
                'is_required'                => 0,
                'user_defined'               => 1,
                'unique'                     => 1,
                'visible'                    => 1,
                'searchable'                 => 1,
                'visible_in_advanced_search' => 1,
                /** Add to attribute Group */
                'group'                      => $groupName,
                'sort_order'                 => 30,
            ]
        );
    }
}
