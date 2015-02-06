<?php
/**
 * @category  German
 * @package   German_LocaleFallback
 * @authors   MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>
 * @developer MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>
 * @version   0.2.0
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @source    http://github.com/magento-hackathon/Hackathon_LocaleFallback
 */
class German_LocaleFallback_Model_System_Config_Source_Locale
{
    public function toOptionArray()
    {
        return array_merge(
            array(array('value' => '', 'label' => 'Disable')),
            Mage::app()->getLocale()->getOptionLocales()
        );
    }
}
