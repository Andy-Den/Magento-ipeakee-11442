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
 * @package     Mage_Sales
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Quote data convert model
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Sales_Model_Convert_Quote extends Varien_Object
{

    /**
     * Convert quote model to order model
     *
     * @param   Mage_Sales_Model_Quote $quote
     * @return  Mage_Sales_Model_Order
     */
    public function toOrder(Mage_Sales_Model_Quote $quote, $order=null)
    {
        if (!($order instanceof Mage_Sales_Model_Order)) {
            $order = Mage::getModel('sales/order');
        }
        /* @var $order Mage_Sales_Model_Order */

        $order->setIncrementId($quote->getReservedOrderId())
            ->setStoreId($quote->getStoreId())
            ->setQuoteId($quote->getId())
            ->setQuote($quote)
            ->setCustomer($quote->getCustomer());

        Mage::helper('core')->copyFieldset('sales_convert_quote', 'to_order', $quote, $order);
        Mage::dispatchEvent('sales_convert_quote_to_order', array('order'=>$order, 'quote'=>$quote));
        return $order;
    }

    /**
     * Convert quote address model to order
     *
     * @param   Mage_Sales_Model_Quote $quote
     * @return  Mage_Sales_Model_Order
     */
    public function addressToOrder(Mage_Sales_Model_Quote_Address $address, $order=null)
    {
        if (!($order instanceof Mage_Sales_Model_Order)) {
            $order = $this->toOrder($address->getQuote());
        }

        Mage::helper('core')->copyFieldset('sales_convert_quote_address', 'to_order', $address, $order);

        Mage::dispatchEvent('sales_convert_quote_address_to_order', array('address'=>$address, 'order'=>$order));
        return $order;
    }

    /**
     * Convert quote address to order address
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Mage_Sales_Model_Order_Address
     */
    public function addressToOrderAddress(Mage_Sales_Model_Quote_Address $address)
    {
        $orderAddress = Mage::getModel('sales/order_address')
            ->setStoreId($address->getStoreId())
            ->setAddressType($address->getAddressType())
            ->setCustomerId($address->getCustomerId())
            ->setCustomerAddressId($address->getCustomerAddressId());

        Mage::helper('core')->copyFieldset('sales_convert_quote_address', 'to_order_address', $address, $orderAddress);

        Mage::dispatchEvent('sales_convert_quote_address_to_order_address',
            array('address' => $address, 'order_address' => $orderAddress));

        return $orderAddress;
    }

    /**
     * Convert quote payment to order payment
     *
     * @param   Mage_Sales_Model_Quote_Payment $payment
     * @return  Mage_Sales_Model_Quote_Payment
     */
    public function paymentToOrderPayment(Mage_Sales_Model_Quote_Payment $payment)
    {
        $orderPayment = Mage::getModel('sales/order_payment')
            ->setStoreId($payment->getStoreId())
            ->setCustomerPaymentId($payment->getCustomerPaymentId());
        Mage::helper('core')->copyFieldset('sales_convert_quote_payment', 'to_order_payment', $payment, $orderPayment);

        Mage::dispatchEvent('sales_convert_quote_payment_to_order_payment',
            array('order_payment' => $orderPayment, 'quote_payment' => $payment));

        return $orderPayment;
    }

    /**
     * Convert quote item to order item
     *
     * @param   Mage_Sales_Model_Quote_Item_Abstract $item
     * @return  Mage_Sales_Model_Order_Item
     */
    public function itemToOrderItem(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        $orderItem = Mage::getModel('sales/order_item')
            ->setStoreId($item->getStoreId())
            ->setQuoteItemId($item->getId())
            ->setQuoteParentItemId($item->getParentItemId())
            ->setProductId($item->getProductId())
            ->setProductType($item->getProductType())
            ->setQtyBackordered($item->getBackorders())
            ->setProduct($item->getProduct())
            ->setBaseOriginalPrice($item->getBaseOriginalPrice())
        ;

        $options = $item->getProductOrderOptions();
        if (!$options) {
            $options = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
        }
        $orderItem->setProductOptions($options);
        Mage::helper('core')->copyFieldset('sales_convert_quote_item', 'to_order_item', $item, $orderItem);

        if ($item->getParentItem()) {
            $orderItem->setQtyOrdered($orderItem->getQtyOrdered()*$item->getParentItem()->getQty());
        }

        if (!$item->getNoDiscount()) {
            Mage::helper('core')->copyFieldset('sales_convert_quote_item', 'to_order_item_discount', $item, $orderItem);
        }

        Mage::dispatchEvent('sales_convert_quote_item_to_order_item',
            array('order_item'=>$orderItem, 'item'=>$item)
        );
        return $orderItem;
    }
}
