<?php
/**
 * @category  German
 * @package   German_LocaleFallback
 * @authors   MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>
 * @developer MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>
 * @version   0.1.0
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class German_LocaleFallback_Block_System_Config_Form_Fieldset_ExtensionsList
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html      = $this->_getHeaderHtml($element);
        $modules   = Mage::getConfig()->getNode('modules')->children();

        foreach ($modules as $moduleName => $values) {
            if (0 !== strpos($moduleName, 'German_')) {
                continue;
            }

            if ($moduleName == 'German_LocaleFallback') {
                continue;
            }

            if ($values->title) {
                $moduleName = (string) $values->title;
            }
            
            $field = $element->addField($moduleName, 'label', array(
                'label' => $moduleName,
                'value' => (string) $values->version
            ));
            $html .= $field->toHtml();
        }
        
        $html .= $this->_getFooterHtml($element);

        return $html;
    }
}
