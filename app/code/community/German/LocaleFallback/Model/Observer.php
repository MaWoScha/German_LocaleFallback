<?php
/**
 * @category  German
 * @package   German_LocaleFallback
 * @authors   MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>
 * @developer MaWoScha <mawoscha@siempro.co, http://www.siempro.co/>
 * @version   0.1.0
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class German_LocaleFallback_Model_Observer {

    /**
     * Get URL of AdminPanel LocalePack section
     *
     * @return string
     */
    public function getManageUrl() {
        return Mage::helper("adminhtml")->getUrl('adminhtml/system_config/edit', array('section'=>'localefallback'));
    }
}
