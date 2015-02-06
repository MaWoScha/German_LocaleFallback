<?php
/**
 * @category  German
 * @package   German_LocaleFallback
 * @authors   MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>, Bastian Ike <b-ike@b-ike.de>
 * @developer MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>, Bastian Ike <b-ike@b-ike.de>
 * @version   0.2.0
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @source    http://github.com/magento-hackathon/Hackathon_LocaleFallback
 */
class German_LocaleFallback_Model_Observer {

    /**
     * @param $observer
     */
    public function compareLocales($observer) {

        $scope = $observer->getStore();
        $helper = Mage::helper("localefallback");
        // get config
        $localePreferred = Mage::getStoreConfig('general/locale/code',          Mage::app()->getStore($scope));
        $localeFallback  = Mage::getStoreConfig('general/locale/code_fallback', Mage::app()->getStore($scope));

        $translationModel = Mage::getModel('localefallback/translate');
        // fetch complete translations
        $translationPreferred = $translationModel->fetchTranslation($localePreferred);
        $translationFallback  = $translationModel->fetchTranslation($localeFallback);
        // get similarities
        $localeSimilarities = array_intersect(
            $translationPreferred,
            $translationFallback
        );
        $session = Mage::getSingleton('adminhtml/session');
        if (count($localeSimilarities) == count($translationPreferred)) {
            $message = $helper->__('Translations are identical, you can safely switch off the Locale Fallback.');
            $session->addNotice($message);
        } else {
            $message = $helper->__('Translations are differing, values from Locale Fallback will be used.');
            $session->addSuccess($message);
        }
    }

    /**
     * Get URL of AdminPanel LocalePack section
     *
     * @return string
     */
    public function getManageUrl() {
        return Mage::helper("adminhtml")->getUrl('adminhtml/system_config/edit', array('section'=>'localefallback'));
    }
}
