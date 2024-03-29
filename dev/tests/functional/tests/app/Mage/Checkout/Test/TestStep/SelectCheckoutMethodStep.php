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

namespace Mage\Checkout\Test\TestStep;

use Mage\Checkout\Test\Page\CheckoutOnepage;
use Mage\Customer\Test\Fixture\Customer;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Selecting checkout method.
 */
class SelectCheckoutMethodStep implements TestStepInterface
{
    /**
     * Onepage checkout page.
     *
     * @var CheckoutOnepage
     */
    protected $checkoutOnepage;

    /**
     * Customer fixture.
     *
     * @var Customer
     */
    protected $customer;

    /**
     * Checkout method.
     *
     * @var string
     */
    protected $checkoutMethod;

    /**
     * @constructor
     * @param CheckoutOnepage $checkoutOnepage
     * @param Customer $customer
     * @param string $checkoutMethod
     */
    public function __construct(CheckoutOnepage $checkoutOnepage, Customer $customer, $checkoutMethod)
    {
        $this->checkoutOnepage = $checkoutOnepage;
        $this->checkoutMethod = $checkoutMethod;
        $this->customer = $customer;
    }

    /**
     * Run step that selecting checkout method.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $checkoutMethodBlock = $this->checkoutOnepage->getLoginBlock();
        switch ($this->checkoutMethod) {
            case 'guest':
                $checkoutMethodBlock->guestCheckout();
                $checkoutMethodBlock->clickContinue();
                break;
            case 'register':
                $checkoutMethodBlock->registerCustomer();
                $checkoutMethodBlock->clickContinue();
                break;
            case 'login':
                $checkoutMethodBlock->loginCustomer($this->customer);
                break;
            default:
                throw new \Exception("Undefined checkout method.");
                break;
        }
    }
}
