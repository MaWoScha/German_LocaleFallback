<?php
/**
 * @category  German
 * @package   German_LocaleFallback
 * @authors   MaWoScha
 * @developer MaWoScha
 * @version   0.3.0
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class German_LocaleFallback_Model_Locale extends Mage_Core_Model_Locale
{
    /**
     * Customer groups cache
     *
     * @var array
     */
    private $_locales;

    /**
     * Retrieve complete locale list from magento
     */
    protected function _getLocales()
    {
        if (is_null($this->_locales))
        {
            $_mage_locales = Mage::getSingleton('core/locale_config')->getAllowedLocales();
            /**
            * ar_YE: Arabisch im Jemen
            * de_LU: Deutsch in Luxemburg
            * en_BZ: Englisch in Belize
            * en_GY: Englisch in Guayana
            * en_HK: Englisch in Hongkonk
            * en_IN: Englisch in Indien
            * en_ZA: Englisch in Suedafrika
            * es_CU: Spanisch auf Cuba
            * fr_BE: Franzoesisch in Belgien
            * fr_CH: Franzoesisch in der Schweiz
            * fr_DZ: Franzoesisch in Algeria
            * fr_GY: Franzoesisch in der Guayana
            * fr_LU: Franzoesisch in Luxemburg
            * fr_PF: Franzoesisch-Polynesisch
            * fr_SN: Franzoesisch im Senegal
            * pt_MZ: Portugiesisch in Mozambique
            * ur_IN: Urdu in Indien
            * ur_PK: Urdu in Pakistan
            *
            * $_more_locales = array('ar_YE','de_LU','en_BZ','en_GY','en_HK','en_IN','en_ZA','es_CU','fr_BE','fr_CH','fr_DZ','fr_GY','fr_LU','fr_PF','fr_SN','pt_MZ','ur_IN','ur_PK');
            * Ersetzt durch das Konfigurationsfeld "localefallback/extra_locales/extra_locale_list"
            */
            $extra_locales = Mage::getStoreConfig('localefallback/extra_locales/extra_locale_list');

            if (!empty ( $extra_locales ) ) {
                $extra_locales = str_replace(";", ",", $extra_locales); // only Comma Not Semicolon
                $_more_locales = explode( ',', $extra_locales );
                $this->_locales = array_merge($_mage_locales,$_more_locales);
            } else {
                $this->_locales = $_mage_locales;
            }
        }

        return $this->_locales;
    }

    /**
     * Retrieve array of allowed locales
     *
     * @return array
     */
    public function getAllowLocales()
    {
        return $this->_getLocales();
    }

}
