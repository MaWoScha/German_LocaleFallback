<?php
/**
 * @category  German
 * @package   German_LocaleFallback
 * @authors   MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>, Bastian Ike <b-ike@b-ike.de>
 * @developer MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>, Bastian Ike <b-ike@b-ike.de>
 * @version   0.4.1
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @source    http://github.com/magento-hackathon/Hackathon_LocaleFallback
 * @source    http://github.com/access3000/Hackathon_LocaleFallback
 */
class German_LocaleFallback_Model_Translate extends Mage_Core_Model_Translate
{
    /**
     * get translation with Zend_Translate_Adapter_Gettext
     *
     * @see Zend_Translate_Adapter_Gettext
     * @param string $file
     * @return array
     */
    protected function _getGettextFileData($file)
    {
        $data = array();
        if (file_exists($file)) {
            $gettextTranslator = new Zend_Translate(array(
                'adapter' => 'Zend_Translate_Adapter_Gettext',
                'content' => $file,
            ));
            $data = $gettextTranslator->getMessages();
        }
        return $data;
    }

    /**
     * iterates thru files, replaces .csv with .mo and tries to load the gettext translation
     *
     * @autor Bastian Ike <b-ike@b-ike.de>
     * @param string $moduleName
     * @param array $files
     * @param bool $forceReload
     * @return German_LocaleFallback_Model_Translate
     */
    protected function _loadGettextModuleTranslation($moduleName, $files, $forceReload=false)
    {
        foreach ($files as $file) {
            $temp = pathinfo($file, PATHINFO_EXTENSION);
            if (isset($temp['extension']) && ($temp['extension'] == 'csv')) {
                $file = substr($file, 0, -3) . 'mo';

                $file = $this->_getModuleFilePath($moduleName, $file);
                $this->_addData($this->_getGettextFileData($file), $moduleName, $forceReload);
            }
        }
        return $this;
    }

    /**
     * loads design locale gettext file
     *
     * @autor Bastian Ike <b-ike@b-ike.de>
     * @param bool $forceReload
     * @return German_LocaleFallback_Model_Translate
     */
    private function _loadGettextTranslation($forceReload)
    {
        $file = Mage::getDesign()->getLocaleFileName('translate.mo');
        $this->_addData($this->_getGettextFileData($file), false, $forceReload);
        return $this;
    }

    /**
     * Initialization translation data
     * line 117 in Mage_Core_Model_Translate
     *
     * rewritten to add gettext
     * gettext is loaded after .csv-files!
     *
     * @modified_by Bastian Ike <b-ike@b-ike.de>
     * @param   string $area
     * @param   boolean $forceReload
     * @return  German_LocaleFallback_Model_Translate
     */
    public function init($area, $forceReload = false)
    {
        $this->setConfig(array(self::CONFIG_KEY_AREA => $area));

        $this->_translateInline = Mage::getSingleton('core/translate_inline')
            ->isAllowed($area=='adminhtml' ? 'admin' : null);

        if (!$forceReload) {
            if ($this->_canUseCache()) {
                $this->_data = $this->_loadCache();
                if ($this->_data !== false) {
                    return $this;
                }
            }
            Mage::app()->removeCache($this->getCacheId());
        }

        $this->_data = array();

		/** START - Bastian Ike */
        if ($localeFallback = Mage::getStoreConfig('general/locale/code_fallback')) {
            // save original locale
            $tmp_locale_original = $this->getLocale();

            // set locale fallback
            $this->setLocale($localeFallback);
            // set global locale to fallback locale
            Mage::getSingleton('core/locale')->setLocale($localeFallback);	/* by access3000 */

            // load translations as usual
            foreach ($this->getModulesConfig() as $moduleName => $info) {
                $info = $info->asArray();
                $this->_loadModuleTranslation($moduleName, $info['files'], $forceReload);
                $this->_loadGettextModuleTranslation($moduleName, $info['files'], $forceReload);
            }

            $this->_loadThemeTranslation($forceReload);
            $this->_loadGettextTranslation($forceReload);
            $this->_loadDbTranslation($forceReload);

            // restore original locale
            $this->setLocale($tmp_locale_original);
            // restore global original locale
            Mage::getSingleton('core/locale')->setLocale($tmp_locale_original);	/* by access3000 */
        }
		/** END - Bastian Ike */

        foreach ($this->getModulesConfig() as $moduleName => $info) {
            $info = $info->asArray();
            $this->_loadModuleTranslation($moduleName, $info['files'], $forceReload);
            $this->_loadGettextModuleTranslation($moduleName, $info['files'], $forceReload);	/* Bastian Ike */
        }

        $this->_loadThemeTranslation($forceReload);
        $this->_loadGettextTranslation($forceReload);	/* Bastian Ike */
        $this->_loadDbTranslation($forceReload);

        if (!$forceReload && $this->_canUseCache()) {
            $this->_saveCache();
        }

        return $this;
    }

    /**
     * Retrive translated template file
     * line 460 in Mage_Core_Model_Translate
     *
     * @modified_by MaWoScha <mawoscha@siempro.co>
     * @param string $file
     * @param string $type
     * @param string $localeCode
     * @return string
     */
    public function getTemplateFile($file, $type, $localeCode=null)
    {
        if (is_null($localeCode) || preg_match('/[^a-zA-Z_]/', $localeCode)) {
            $localeCode = $this->getLocale();
        }

        $filePath = Mage::getBaseDir('locale')  . DS
                  . $localeCode . DS . 'template' . DS . $type . DS . $file;

		/** START - MaWoScha */
        if (!file_exists($filePath)) { // If template doesn't exist for this locale, use fallback locale
            $filePath = Mage::getBaseDir('locale') . DS
                      . Mage::getStoreConfig('general/locale/code_fallback')
                      . DS . 'template' . DS . $type . DS . $file;
        }
		/** END - MaWoScha */

        if (!file_exists($filePath)) { // If template doesn't exist for fallback locale, use store default
            $filePath = Mage::getBaseDir('locale') . DS
                      . Mage::app()->getLocale()->getDefaultLocale()
                      . DS . 'template' . DS . $type . DS . $file;
        }

        if (!file_exists($filePath)) {  // If template doesn't exist for store default, use en_US
            $filePath = Mage::getBaseDir('locale') . DS
                      . Mage_Core_Model_Locale::DEFAULT_LOCALE
                      . DS . 'template' . DS . $type . DS . $file;
        }

        $ioAdapter = new Varien_Io_File();
        $ioAdapter->open(array('path' => Mage::getBaseDir('locale')));

        return (string) $ioAdapter->read($filePath);
    }

    /**
     * Load Translation for specific locale and return translation data
     * Used in: German_LocaleFallback_Model_Observer
     *
     * @autor Bastian Ike <b-ike@b-ike.de>
     * @param $locale
     * @return array
     */
    public function fetchTranslation($locale)
    {
        // Set Config
        $this->setConfig(array(self::CONFIG_KEY_AREA => 'adminhtml'));
        // save original locale
        $tmp_locale_original = $this->getLocale();

        $this->setLocale($locale);
        Mage::getSingleton('core/locale')->setLocale($locale);	/* by access3000 */

        $this->_data = array();
        foreach ($this->getModulesConfig() as $moduleName => $info) {
            $info = $info->asArray();
            $this->_loadModuleTranslation($moduleName, $info['files'], false);
            $this->_loadGettextModuleTranslation($moduleName, $info['files'], false);
        }
        $this->_loadThemeTranslation(false);
        $this->_loadGettextTranslation(false);
        $this->_loadDbTranslation(false);

        // restore original locale
        $this->setLocale($tmp_locale_original);	/* by access3000 */
        // restore global original locale
        Mage::getSingleton('core/locale')->setLocale($tmp_locale_original);	/* by access3000 */

        return $this->getData();
    }
}
