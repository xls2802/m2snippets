<?php

declare(strict_types=1);

namespace Andrew\AttributeForCategory\Setup;

use Magento\Catalog\Api\Data\CategoryAttributeInterface;
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
    )
    {
        /** For version compatibility */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $attributeCode = 'external_id';

        /**
         * For attribute property look at \Magento\Eav\Model\Entity\Setup\PropertyMapperInterface
         *
         * 1. Eav Property Mapper - \Magento\Eav\Model\Entity\Setup\PropertyMapper - main
         * 2. Catalog Property Mapper - \Magento\Catalog\Model\ResourceModel\Setup\PropertyMapper
         */

        $eavSetup->addAttribute(CategoryAttributeInterface::ENTITY_TYPE_CODE, $attributeCode,
            [
                'label' => 'External ID',
                'user_defined' => 1,
                'unique' => 1,
            ]
        );

        /**
         * Add attribute_code external_id in default attribute set and default attribute grouped
         *
         * If there is a store in your properties then use  $eavSetup->addAttributeGroup for add custom attribute in group
         * If this default attribute then use $eavSetup->addAttributeToGroup for add attribute in group
         */
        $setId = $eavSetup->getDefaultAttributeSetId(CategoryAttributeInterface::ENTITY_TYPE_CODE);
        $groupId = $eavSetup->getDefaultAttributeGroupId(CategoryAttributeInterface::ENTITY_TYPE_CODE, $setId);
        $eavSetup->addAttributeToSet(CategoryAttributeInterface::ENTITY_TYPE_CODE, $setId, $groupId, $attributeCode);

    }
}
