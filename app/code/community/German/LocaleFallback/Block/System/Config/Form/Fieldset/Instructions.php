<?php
/**
 * @category  German
 * @package   German_LocaleFallback
 * @authors   MaWoScha
 * @developer MaWoScha
 * @version   0.5.0
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class German_LocaleFallback_Block_System_Config_Form_Fieldset_Instructions
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $helper = Mage::helper("localefallback");

        $html  = $this->_getHeaderHtml($element);
        $html .= "<p>";
        $html .= $helper->__("Magento has only one variable available for the locale (<a href='%s'>locale</a>). This extension now provides two settings:",
                Mage::helper('adminhtml')->getUrl('adminhtml/system_config/edit', array('section'=>'general')));
        $html .= "</p>";

        $html .= "<ol style='list-style-position: outside; list-style-type: disc; margin-left:18px;'>";
        $html .= "<li>".$helper->__('Locale Preferred')."</li>";
        $html .= "<li>".$helper->__('Locale Fallback')."</li>";
        $html .= '</ol>';

        $html .= "<p>".$helper->__("Now it is possible to use a preferred language with a fallback language. Thus it can be set as the preferred language a partially available language, the fallback language then takes over the lack of rest.")."</p>";
        $html .= "<p>".$helper->__("You want to sell and make use of the language of your target audience. Magento supports it – at least in theory. Practically, it is then but so that for most languages no language packs are available for Magento. Creating your own custom language pack fails again mostly at the expense: The language files of Magento contain several thousand entries.")."</p>";
        $html .= "<p>".$helper->__("However, the complexity is significantly lower when only a limited selection of entries had to be translated and for the rest a fallback language could be defined. That would be also safe in case of updating the Magento software.")."</p>";
        $html .= "<p>".$helper->__("The fallback language, which complements the missing entries of their own language pack, can be defined here. First, however, one's own language pack must be installed. The process can be reversed.")."</p>";
        $html .= "<hr style='margin-top:20px;'>";

        $html .= $helper->__("This package is simply adding three Static Blocks to the <a href='%s'>E-Mail-Templates</a>:",
                Mage::helper('adminhtml')->getUrl('adminhtml/system_email_template'));
        $html .= "<ul style='list-style-position: outside; list-style-type: disc; margin-left:18px;'>";
        $html .= "<li>email_template_say_hello &nbsp; (".$helper->__("Salutation").")</li>";
        $html .= "<li>email_template_contact &nbsp; (".$helper->__("Contact information").")</li>";
        $html .= "<li>email_template_say_bye &nbsp; (".$helper->__("Closing formula").")</li>";
        $html .= "</ul>";
        $html .= "<p>";
        $html .= $helper->__("The static blocks can be managed by the <a href='%s'>CMS system</a> in the admin area.",
                Mage::helper('adminhtml')->getUrl('adminhtml/cms_block'));
        $html .= "</p>";
        $html .= "<hr style='margin-top:20px;'><p>";

        $html .= $helper->__("For localized packages you can add packages with locals as <a href='%s' target='_blank'>de_ZZ</a>, <a href='%s' target='_blank'>en_ZZ</a>, <a href='%s' target='_blank'>es_ZZ</a>, <a href='%s' target='_blank'>fr_ZZ</a> and so forth.",
                'https://github.com/MaWoScha/German_LocalePack_de_ZZ',
                'https://github.com/MaWoScha/German_LocalePack_en_ZZ',
                'https://github.com/MaWoScha/German_LocalePack_es_ZZ',
                'https://github.com/MaWoScha/German_LocalePack_fr_ZZ');
        $html .= " " . $helper->__("Also a informal German version <a href='%s' target='_blank'>de_DE_DU</a> is available.",
                'https://github.com/MaWoScha/German_LocalePack_de_DE_DU');
        $html .= "</p><p style='text-align:right;'>";
        $html .= $helper->__("powered by")." <a href='https://github.com/mawoscha/German_LocaleFallback' target='_blank'>MaWoScha</a>";
        $html .= "</p>";
        $html .= $this->_getFooterHtml($element);

        return $html;
    }
}
