<?php

/**
 * Default entity attribute mapper
 *
 * 'attribute_model' => 'attribute_model'
 * 'backend_model' => 'backend' // Allows you to perform certain actions when an attribute is loaded or saved.
 * 'backend_type' => 'type', defaul value text (varchar) // Attribute type (varchar, text, int, decimal...)
 * 'backend_table' => 'table' // Additional properties for the attribute
 * 'frontend_model' => 'frontend' // Defines how it should be rendered on the frontend
 * 'frontend_input' => 'input' defaul value (text) // Input type (text, textarea, select...)
 * 'frontend_label' => 'label' // Default label
 * 'frontend_class' => 'frontend_class' // Tag can be used to modify the class attribute of the form element tag that’s
 *  generated for your field. That is, this config field allows you to add a Cascading Stylesheet Class (i.e. “frontend” class) to the generated form element.
 * 'source_model' => 'source' // Use for select attribute value in input
 * 'is_required' => 'required', defaul value (true) //Is the attribute mandatory?
 * 'is_user_defined' => 'user_defined', defaul value (false) // Is the attribute user defined? If false the attribute isn't removable. TRUE needed if configurable attribute.
 * 'default_value' => 'default' // attribute default value
 * 'is_unique' => 'unique', defaul value (false) // Must attribute values be unique?
 * 'note' => 'note' // Note below the input field on admin area
 * 'is_global' => 'global', defaul value (SCOPE_GLOBAL) // Attribute scope
 */

/**
 *  Customer attribute property mapper
 *
 * 'is_visible' => 'visible', default value (true) Is the attribute visible? If true the field appears in admin page.
 * 'is_system' => 'system', default value (true) // Attribute deny to change some specific options on attribute edit page
 * 'input_filter' => 'input_filter', default value (null) // Template used for input (e.g. "date")
 * 'multiline_count' => 'multiline_count', default value (false) // Number of lines of the attribute value.
 * 'validate_rules' => 'validate_rules', default value (null) // Takes to validate form
 * 'data_model' => 'data', default value (null) // Data model for attribute.
 * 'sort_order' => 'position', default value (false) // Which position on the admin area form group?
 * 'is_used_in_grid' => 'is_used_in_grid', default value (false) // Whether it is used in customer grid
 * 'is_visible_in_grid' => 'is_visible_in_grid', default value (false) // Whether it is visible in customer grid
 * 'is_filterable_in_grid' => 'is_filterable_in_grid', default value (false) // Whether it is filterable in customer grid
 * 'is_searchable_in_grid' => 'is_searchable_in_grid', default value (false) // Whether it is searchable in customer grid
 */

declare(strict_types=1);

namespace Andrew\AddCustomerAddress\Setup;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Create new EAV attribute
 *
 * @package Andrew\AddCustomerAddress\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetup
     */
    private $eavSetupFactory;

    private $eavConfig;

    /**
     * InstallData constructor.
     *
     * @param EavSetup $eavSetup
     */
    public function __construct
    (
        EavSetupFactory $eavSetup,
        EavConfig $eavConfig
    )
    {
        $this->eavSetupFactory = $eavSetup;
        $this->eavConfig = $eavConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function install
    (
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        /** For version compatibility */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        /** @var  $attributeCode */
        $attributeCode = 'is_home_address';

        /**
         * For attribute property look at \Magento\Eav\Model\Entity\Setup\PropertyMapperInterface
         *
         * 1. Eav Property Mapper - \Magento\Eav\Model\Entity\Setup\PropertyMapper - main
         * 2. Customer Address Property Mapper - Magento\Customer\Model\ResourceModel\Setup\PropertyMapper
         * 3. Configurable Product Property Mapper -
         *      \Magento\ConfigurableProduct\Model\ResourceModel\Setup\PropertyMapper - this not used in magento 2
         */

        /**
         * Add attribute for customer, look in mysql table eav_attribute
         * entity_type_code customer_address
         * entity_model Magento\Customer\Model\ResourceModel\Address
         */
        $eavSetup->addAttribute(AddressMetadataInterface::ENTITY_TYPE_ADDRESS, $attributeCode,
            [
                /** save type table eav_attribute in fields backend_type  */
                'type' => 'int',
                /** type inpute for admin panel*/
                'input' => 'boolean',
                /** 'lable' - Name for attribute */
                'label' => 'Is home address?',
                /** 'is_required' -  If required => true(1), then the attribute must have any value when
                 *   you create a customer address. */
                'required' => 0,
                /** 'user_defined' - System attributes cannot be deleted, by default every added attribute is
                system but if you set the user_defined field to true (1) then the attribute
                will be user-defined and we will be able to remove it. */
                'user_defined' => 1,
                /** 'default' - With this, you can set a default value. */
                'default' => 0,
                /** system attribute or not */
                'system' => 0,
                /** position attribute in admin panel */
                'position' => 50,
            ]
        );

        /** Add attribute to group */
        $eavSetup->addAttributeToSet(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            AddressMetadataInterface::ATTRIBUTE_SET_ID_ADDRESS,
            null,
            $attributeCode
        );

        /** Form use area */
        $attribute = $this->eavConfig->getAttribute(AddressMetadataInterface::ENTITY_TYPE_ADDRESS, $attributeCode);
        $attribute->setData('used_in_forms',
            [
                /** Form visibility in */
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address',
            ]
        );

        $attribute->getResource()->save($attribute);

        $setup->endSetup();
    }


}
