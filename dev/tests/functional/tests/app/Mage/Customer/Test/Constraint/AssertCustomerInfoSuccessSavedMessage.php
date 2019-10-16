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

namespace Mage\Customer\Test\Constraint;

use Mage\Customer\Test\Page\CustomerAccountIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Asserts that success message equals to expected message.
 */
class AssertCustomerInfoSuccessSavedMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Text value to be checked.
     */
    const SUCCESS_MESSAGE = 'The account information has been saved.';

    /**
     * Asserts that success message equals to expected message.
     *
     * @param CustomerAccountIndex $customerAccountIndex
     * @return void
     */
    public function processAssert(CustomerAccountIndex $customerAccountIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_MESSAGE,
            $customerAccountIndex->getMessagesBlock()->getSuccessMessages()
        );
    }

    /**
     * Returns success message if equals to expected message.
     *
     * @return string
     */
    public function toString()
    {
        return 'Success customer info save message on customer account index page is correct.';
    }
}
