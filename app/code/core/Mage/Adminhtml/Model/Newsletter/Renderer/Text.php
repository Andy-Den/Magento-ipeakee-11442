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
 * @package     Mage_Adminhtml
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Template text preview field renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Model_Newsletter_Renderer_Text implements Varien_Data_Form_Element_Renderer_Interface
{

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = '<tr><td class="label">'."\n";
        if ($element->getLabel()) {
            $html.= '<label for="'.$element->getHtmlId().'">'.$element->getLabel().'</label>'."\n";
        }
        $html.= '</td><td class="value">
<iframe src="' . $element->getValue() . '" id="' . $element->getHtmlId() . '" frameborder="0" class="template-preview"> </iframe>';
        $html.= '</td><td></td></tr>'."\n";

        return $html;
    }
}
