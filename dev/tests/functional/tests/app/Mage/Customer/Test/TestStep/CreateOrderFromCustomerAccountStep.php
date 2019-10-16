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
 * @category    Tests
 * @package     Tests_Functional
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

namespace Mage\Customer\Test\TestStep;

use Mage\Customer\Test\Page\Adminhtml\CustomerEdit;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Create order from customer page on backend.
 */
class CreateOrderFromCustomerAccountStep implements TestStepInterface
{
    /**
     * Customer edit page.
     *
     * @var CustomerEdit
     */
    protected $customerIndexEdit;

    /**
     * @constructor
     * @param CustomerEdit $customerIndexEdit
     */
    public function __construct(CustomerEdit $customerIndexEdit)
    {
        $this->customerIndexEdit = $customerIndexEdit;
    }

    /**
     * Create new order from customer.
     *
     * @return void
     */
    public function run()
    {
        $this->customerIndexEdit->getPageActionsBlock()->createOrder();
    }
}
