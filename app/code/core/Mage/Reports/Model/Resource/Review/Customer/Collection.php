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
 * @category    Mage
 * @package     Mage_Reports
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Report Customers Review collection
 *
 * @category    Mage
 * @package     Mage_Reports
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Reports_Model_Resource_Review_Customer_Collection extends Mage_Review_Model_Resource_Review_Collection
{
    /**
     * Join customers
     *
     * @return Mage_Reports_Model_Resource_Review_Customer_Collection
     */
    public function joinCustomers()
    {
        /**
         * Allow to use analytic function to result select
         */
        $this->_useAnalyticFunction = true;

        /** @var $adapter Varien_Db_Adapter_Interface */
        $adapter            = $this->getConnection();
        /** @var $customer Mage_Customer_Model_Resource_Customer */
        $customer           = Mage::getResourceSingleton('customer/customer');
        /** @var $firstnameAttr Mage_Eav_Model_Entity_Attribute */
        $firstnameAttr      = $customer->getAttribute('firstname');
        /** @var $firstnameAttr Mage_Eav_Model_Entity_Attribute */
        $middlenameAttr      = $customer->getAttribute('middlename');
        /** @var $lastnameAttr Mage_Eav_Model_Entity_Attribute */
        $lastnameAttr       = $customer->getAttribute('lastname');

        $firstnameCondition = array('table_customer_firstname.entity_id = detail.customer_id');

        if ($firstnameAttr->getBackend()->isStatic()) {
            $firstnameField = 'firstname';
        } else {
            $firstnameField = 'value';
            $firstnameCondition[] = $adapter->quoteInto(
                'table_customer_firstname.attribute_id = ?',
                (int) $firstnameAttr->getAttributeId()
            );
        }

        $this->getSelect()->joinInner(
            array('table_customer_firstname' => $firstnameAttr->getBackend()->getTable()),
            implode(' AND ', $firstnameCondition),
            array()
        );

        $middlenameCondition = array('table_customer_middlename.entity_id = detail.customer_id');

        if ($middlenameAttr->getBackend()->isStatic()) {
            $middlenameField = 'middlename';
        } else {
            $middlenameField = 'value';
            $middlenameCondition[] = $adapter->quoteInto(
                'table_customer_middlename.attribute_id = ?',
                (int) $middlenameAttr->getAttributeId()
            );
        }

        $this->getSelect()->joinInner(
            array('table_customer_middlename' => $middlenameAttr->getBackend()->getTable()),
            implode(' AND ', $middlenameCondition),
            array()
        );

        $lastnameCondition  = array('table_customer_lastname.entity_id = detail.customer_id');
        if ($lastnameAttr->getBackend()->isStatic()) {
            $lastnameField = 'lastname';
        } else {
            $lastnameField = 'value';
            $lastnameCondition[] = $adapter->quoteInto(
                'table_customer_lastname.attribute_id = ?',
                (int) $lastnameAttr->getAttributeId()
            );
        }

        //Prepare fullname field result
        $customerFullname = $adapter->getConcatSql(array(
            "table_customer_firstname.{$firstnameField}",
            "table_customer_middlename.{$middlenameField}",
            "table_customer_lastname.{$lastnameField}"
        ), ' ');
        $this->getSelect()->reset(Zend_Db_Select::COLUMNS)
            ->joinInner(
                array('table_customer_lastname' => $lastnameAttr->getBackend()->getTable()),
                implode(' AND ', $lastnameCondition),
                array())
            ->columns(array(
                'customer_id' => 'detail.customer_id',
                'customer_name' => $customerFullname,
                'review_cnt'    => 'COUNT(main_table.review_id)'))
            ->group('detail.customer_id');

        return $this;
    }

    /**
     * Get select count sql
     *
     * @return string
     */
    public function getSelectCountSql()
    {
        $countSelect = clone $this->_select;
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::GROUP);
        $countSelect->reset(Zend_Db_Select::HAVING);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $countSelect->reset(Zend_Db_Select::COLUMNS);

        $countSelect->columns(new Zend_Db_Expr('COUNT(DISTINCT detail.customer_id)'));

        return  $countSelect;
    }
}
