<?php
/**
 * Created by PhpStorm.
 * User: israel
 * Date: 2019-03-17
 * Time: 23:10
 */

namespace Aye\Zamora\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Zamora extends AbstractHelper
{

    const XML_PATH_HELLOWORLD = 'zamora/';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {

        return $this->getConfigValue(self::XML_PATH_HELLOWORLD .'general/'. $code, $storeId);
    }

}