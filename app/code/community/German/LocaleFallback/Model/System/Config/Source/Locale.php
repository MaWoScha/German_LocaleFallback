<?php
/**
 * @category  German
 * @package   German_LocaleFallback
 * @authors   MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>
 * @developer MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>
 * @version   0.3.0
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @source    http://github.com/magento-hackathon/Hackathon_LocaleFallback
 */
class German_LocaleFallback_Model_System_Config_Source_Locale
{
    public function toOptionArray()
    {
        $_mage_fallbacks = Mage::app()->getLocale()->getOptionLocales();

        /**
        * Additional fallback languages
        * - ar Arabish
        * - en English
        * - ur Urdu
        $_more_Languages = array('ar', 'en', 'ur');
        $_more_fallbacks = array(array('value' => 'ar', 'label' => 'Arabic (ar_AR, Fallback)'), array('value' => 'en', 'label' => 'English (en_EN, Fallback)'), array('value' => 'ur', 'label' => 'Urdu (ur_UR, Fallback)'));
		* Ersetzt durch das Konfigurationsfeld "localefallback/extra_locales/extra_fallback_list"
        */
        $_more_fallbacks = array();

		$_more_Languages = Mage::getStoreConfig('localefallback/extra_locales/extra_fallback_list');
		if (!empty ( $_more_Languages ) ) {
			$_more_Languages = str_replace(";", ",", $_more_Languages); // only Comma Not Semicolon
			$_more_Languages = explode( ',', $_more_Languages );

			$languages = Mage::app()->getLocale()->getTranslationList('language', Mage::app()->getLocale()->getLocaleCode());
			$countries = Mage::app()->getLocale()->getCountryTranslationList();

			foreach ($_more_Languages as $code_lang) {
				$code  = $code_lang.'_'.strtoupper($code_lang);
				$label = $languages[$code_lang] . ' (' . $code . ', Fallback)';
				$_more_fallbacks[] = array(
					'value' => $code,
					'label' => $label
				);
			}
		}

        return array_merge(
            array(array('value' => '', 'label' => 'Disable')),
            $_mage_fallbacks,
            $_more_fallbacks
        );
    }
}
