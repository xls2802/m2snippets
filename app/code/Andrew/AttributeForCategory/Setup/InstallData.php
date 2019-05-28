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
 * Catalog attribute property mapper
 *
 * 'frontend_input_renderer' => 'input_renderer' // Definition of renderer
 * 'is_global' => 'global',default value (SCOPE_GLOBAL) // Attribute scope
 * 'is_visible' => 'visible', default value (true) // Is the attribute visible? If true the field appears in admin product page.
 * 'is_searchable' => 'searchable', default value (false) // Is the attribute searchable?
 * 'is_filterable' => 'filterable', default value (false) // Is the attribute filterable? (on frontend, in category view)
 * 'is_comparable' => 'comparable', default value (false) // Can the attribute be used to create configurable products?
 * 'is_visible_on_front' => 'visible_on_front', default value (false) // Is the attribute visible on front?
 * 'is_wysiwyg_enabled' => 'wysiwyg_enabled', default value (false) // Is Wysiwyg enabled? (use `textarea` input if you put that value to true)
 * 'is_html_allowed_on_front' => 'is_html_allowed_on_front', default value (false) // Is HTML allowed on frontend?
 * 'is_visible_in_advanced_search' =>'visible_in_advanced_search', default value (false) // Is the attribute visible on advanced search?
 * 'is_filterable_in_search' => 'filterable_in_search', default value (false) // Is the attribute filterable? (on frontend, in search view)
 * 'used_in_product_listing' => 'used_in_product_listing', default value (false) // Should we flat this attribute?
 * 'used_for_sort_by' => 'used_for_sort_by', default value (false) // Can the attribute be used for the 'sort by' select on catalog/search views?
 * 'apply_to' => 'apply_to' //  Product types
 * 'position' => 'position', default value (false) // Which position on the admin area form group?
 * 'is_used_for_promo_rules' => 'used_for_promo_rules', default value (false) // Do we need that attribute for specific promo rules?
 * 'is_used_in_grid' => 'is_used_in_grid', default value (false) // Whether it is used in customer grid
 * 'is_visible_in_grid' => 'is_visible_in_grid', default value (false) // Whether it is visible in customer grid
 * 'is_filterable_in_grid' => 'is_filterable_in_grid', default value (false) // Whether it is filterable in customer grid
 *
 */

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
 * @package Andrew\AttributeForCategory\Setup
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

        /** @var  $attributeCode */
        $attributeCode = 'external_id';

        /**
         * For attribute property look at \Magento\Eav\Model\Entity\Setup\PropertyMapperInterface
         *
         * 1. Eav Property Mapper - \Magento\Eav\Model\Entity\Setup\PropertyMapper - main
         * 2. Category Property Mapper - \Magento\Catalog\Model\ResourceModel\Setup\PropertyMapper
         * 3. Configurable Product Property Mapper -
         *      \Magento\ConfigurableProduct\Model\ResourceModel\Setup\PropertyMapper - this not used in magento 2
         */

        /**
         * Add attribute for category, look in mysql table eav_attribute
         * entity_type_code catalog_category
         * entity_model Magento\Catalog\Model\ResourceModel\Category
         */
        $eavSetup->addAttribute(CategoryAttributeInterface::ENTITY_TYPE_CODE, $attributeCode,
            [
                /** 'lable' - Name for attribute 'label' => 'AttributeName' */
                'label' => 'External ID',
                /** 'user_defined' - System attributes cannot be deleted, by default every added attribute is
                system but if you set the user_defined field to true (1) then the attribute
                will be user-defined and we will be able to remove it. */
                'user_defined' => 1,
                /** 'unique' - Specifies the ability to add an attribute with the same name (lable) if 'unique' => true (1),
                then a new attribute with the same name cannot be created */
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
