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
 * Catalog redirect model
 * The class provides interface to the enterprise_catalog_category_rewrite table.
 *
 * @category    Enterprise
 * @package     Enterprise_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Catalog_Model_Category extends Mage_Core_Model_Abstract
{
    /**
     * Url Rewrite Entity Type
     */
    const URL_REWRITE_ENTITY_TYPE = 2;

    /**
     * Initialize resources
     */
    protected function _construct()
    {
        $this->_init('enterprise_catalog/category');
    }

    /**
     * Load url rewrite based on specified category
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Enterprise_Catalog_Model_Category
     */
    public function loadByCategory(Mage_Catalog_Model_Category $category)
    {
        $this->_getResource()->loadByCategory($this, $category);
        return $this;
    }
}
