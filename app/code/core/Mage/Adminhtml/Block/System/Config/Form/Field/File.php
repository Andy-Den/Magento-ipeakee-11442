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
 * File config field renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_System_Config_Form_Field_File extends Varien_Data_Form_Element_File
{
    /**
     * Get element html
     *
     * @return string
     */
    public function getElementHtml()
    {
        $html = parent::getElementHtml();
        $html .= $this->_getDeleteCheckbox();
        return $html;
    }

    /**
     * Get html for additional delete checkbox field
     *
     * @return string
     */
    protected function _getDeleteCheckbox()
    {
        $html = '';
        if ((string)$this->getValue()) {
            $label = Mage::helper('adminhtml')->__('Delete File');
            $html .= '<div>'.$this->getValue().' ';
            $html .= '<input type="checkbox" name="'.parent::getName().'[delete]" value="1" class="checkbox" id="'.$this->getHtmlId().'_delete"'.($this->getDisabled() ? ' disabled="disabled"': '').'/>';
            $html .= '<label for="'.$this->getHtmlId().'_delete"'.($this->getDisabled() ? ' class="disabled"' : '').'> '.$label.'</label>';
            $html .= '<input type="hidden" name="'.parent::getName().'[value]" value="'.$this->getValue().'" />';
            $html .= '</div>';
        }
        return $html;
    }
}
