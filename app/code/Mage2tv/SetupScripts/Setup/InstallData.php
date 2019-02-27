<?php

declare(strict_types=1);

namespace Mage2tv\SetupScripts\Setup;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Install attributes
 */
class InstallData implements InstallDataInterface
{

    /**
     * @var $eavSetupFactory
     */
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' =>$setup]);

        $attributeCode = 'legacy_sku';

        $eavSetup->addAttribute(ProductAttributeInterface::ENTITY_TYPE_CODE , $attributeCode, [
            
        ]);
    }


}