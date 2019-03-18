<?php
/**
 * Created by PhpStorm.
 * User: israel
 * Date: 2019-03-17
 * Time: 23:12
 */

namespace Aye\Zamora\Block;

use \Aye\Zamora\Helper\Zamora as HelperData;


class Banner extends \Magento\Framework\View\Element\Template
{
    var $_helperData;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        HelperData $_helperData
    )
    {
        $this->_helperData = $_helperData;
        parent::__construct($context);
    }

    public function getEnableBanner()
    {
        return $this->_helperData->getGeneralConfig('enable');
    }

    public function getUrlBanner()
    {
        return $this->_helperData->getGeneralConfig('display_text');
    }
}