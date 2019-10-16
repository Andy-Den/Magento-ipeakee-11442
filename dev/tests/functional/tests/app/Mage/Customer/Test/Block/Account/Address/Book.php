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

namespace Mage\Customer\Test\Block\Account\Address;

use Magento\Mtf\Block\Block;

/**
 * Address book block on customer address page.
 */
class Book extends Block
{
    /**
     * Additional address entries selector.
     *
     * @var string
     */
    protected $additionalAddress = '.addresses-additional';

    /**
     * Get additional address block.
     *
     * @return AdditionalAddress
     */
    public function getAdditionalAddressBlock()
    {
        return $this->blockFactory->create(
            'Mage\Customer\Test\Block\Account\Address\AdditionalAddress',
            ['element' => $this->_rootElement->find($this->additionalAddress)]
        );
    }
}
