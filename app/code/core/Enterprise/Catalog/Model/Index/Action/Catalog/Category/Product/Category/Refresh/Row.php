<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Enterprise
 * @package     Enterprise_Catalog
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Category/Product index refresh by row action
 *
 * @category    Enterprise
 * @package     Enterprise_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Catalog_Model_Index_Action_Catalog_Category_Product_Category_Refresh_Row
    extends Enterprise_Catalog_Model_Index_Action_Catalog_Category_Product_Refresh
{
    /**
     * Limitation by categories
     *
     * @var array|Varien_Db_Select
     */
    protected $_limitationByCategories;

    /**
     * Constructor with parameters
     * Array of arguments with keys
     *  - 'metadata' Enterprise_Mview_Model_Metadata
     *  - 'connection' Varien_Db_Adapter_Interface
     *  - 'factory' Enterprise_Mview_Model_Factory
     *  - 'value' mixed
     *
     * @param array $args
     * @throws Enterprise_Index_Model_Action_Exception
     */
    public function __construct(array $args)
    {
        if (isset($args['value']) && !empty($args['value'])) {
            $this->_limitationByCategories = is_array($args['value']) ? $args['value'] : array($args['value']);
        }

        parent::__construct($args);
    }

    /**
     * Run reindex
     *
     * @return Enterprise_Catalog_Model_Index_Action_Catalog_Category_Product_Category_Refresh_Row
     * @throws Enterprise_Index_Model_Action_Exception
     */
    public function execute()
    {
        if (empty($this->_limitationByCategories)) {
            throw new Enterprise_Index_Model_Action_Exception('Value can not be empty');
        }

        return parent::execute();
    }

    /**
     * Execute additional operations before reindex
     *
     * @return Enterprise_Catalog_Model_Index_Action_Catalog_Category_Product_Category_Refresh_Row
     */
    protected function _beforeReindex()
    {
        return $this;
    }

    /**
     * Execute additional operations after reindex
     *
     * @return Enterprise_Catalog_Model_Index_Action_Catalog_Category_Product_Category_Refresh_Row
     */
    protected function _afterReindex()
    {
        return $this;
    }

    /**
     * Return select for remove unnecessary data
     *
     * @param array $storeIds
     * @return Varien_Db_Select
     */
    protected function _getSelectUnnecessaryData($storeIds)
    {
        $select = parent::_getSelectUnnecessaryData($storeIds);
        return $select->where($this->_getMainTable() . '.category_id IN (?)', $this->_limitationByCategories);
    }

    /**
     * Retrieve select for reindex products of non anchor categories
     *
     * @param Mage_Core_Model_Store $store
     * @return Varien_Db_Select
     */
    protected function _getNonAnchorCategoriesSelect(Mage_Core_Model_Store $store)
    {
        $select = parent::_getNonAnchorCategoriesSelect($store);
        return $select->where('cc.entity_id IN (?)', $this->_limitationByCategories);
    }

    /**
     * Retrieve select for reindex products of non anchor categories
     *
     * @deprecated
     *
     * @param Mage_Core_Model_Store $store
     * @return Varien_Db_Select
     */
    protected function _getAnchorCategoriesSelect(Mage_Core_Model_Store $store)
    {
        $select = parent::_getAnchorCategoriesSelect($store);
        return $select->where('cc.entity_id IN (?)', $this->_limitationByCategories);
    }

    /**
     * Retrieve select for reindex products of non anchor categories
     *
     * @param Mage_Core_Model_Store $store
     * @return Varien_Db_Select
     */
    protected function _getAnchorCategoriesSubSelect(Mage_Core_Model_Store $store)
    {
        $select = parent::_getAnchorCategoriesSubSelect($store);
        return $select->where('cc.entity_id IN (?)', $this->_limitationByCategories);
    }

    /**
     * Get select for all products
     *
     * @param $store
     * @return Varien_Db_Select
     */
    protected function _getAllProducts(Mage_Core_Model_Store $store)
    {
        $select = parent::_getAllProducts($store);
        return $select->where($store->getRootCategoryId() . ' IN (?)', $this->_limitationByCategories);
    }

    /**
     * Return selects cut by min and max
     *
     * @param Varien_Db_Select $select
     * @param string $field
     * @param int $range
     * @return array
     */
    protected function _prepareSelectsByRange(Varien_Db_Select $select, $field, $range = self::RANGE_CATEGORY_STEP)
    {
        return array($select);
    }

    /**
     * Dispatches an event after reindex
     *
     * @return Enterprise_Catalog_Model_Index_Action_Catalog_Category_Product_Category_Refresh_Row
     */
    protected function _dispatchNotification()
    {
        $this->_app->dispatchEvent('catalog_category_product_cat_partial_reindex',
            array('category_ids' => $this->_limitationByCategories));
        return $this;
    }
}
