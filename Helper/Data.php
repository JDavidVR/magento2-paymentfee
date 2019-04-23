<?php

/**
 * MagePrince
 * Copyright (C) 2019 Mageprince
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html
 *
 * @category MagePrince
 * @package Prince_Paymentfee
 * @copyright Copyright (c) 2018 MagePrince
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MagePrince
 */

namespace Prince\Paymentfee\Helper;

use Magento\Customer\Model\Session as CustomerSession;
use Prince\Paymentfee\Model\Config\Source\ConfigData;

/**
 * Class Data
 * @package Prince\Paymentfee\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * ScopeConfig
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $_scopeConfig;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    private $serialize;

    /**
     * @var array
     */
    public $methodFee = NULL;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeInterface
     * @param \Magento\Framework\Serialize\Serializer\Json $serialize
     * @param CustomerSession $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeInterface,
        \Magento\Framework\Serialize\Serializer\Json $serialize,
        CustomerSession $customerSession
    ) {
        $this->_scopeConfig = $scopeInterface;
        $this->serialize = $serialize;
        $this->customerSession = $customerSession;
        $this->_getPaymentFee();
    }

    /**
     * @param $config
     * @return mixed
     */
    public function getConfig($config)
    {
        return $this->_scopeConfig->getValue(
            $config, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get module status
     *
     * @return bool
     */
    public function isEnable()
    {
        return $this->getConfig(ConfigData::MODULE_STATUS_XML_PATH);
    }

    /**
     * @return bool
     */
    public function isShowZeroPaymentFee()
    {
        return $this->getConfig(ConfigData::PAYMENTFEE_ZEROPAYMENT_XML_PATH);
    }

    /**
     * Get description status
     *
     * @return bool
     */
    public function isDescription()
    {
        return $this->getConfig(ConfigData::PAYMENTFEE_SHOW_DESCRIPTION_XML_PATH);
    }

    /**
     * Get description
     *
     * @return bool
     */
    public function getDescription()
    {
        return $this->getConfig(ConfigData::PAYMENTFEE_DESCRIPTION_XML_PATH);
    }
    /**
     * Get minimum order amount to add paymentfee
     *
     * @return bool
     */
    public function getMinOrderTotal()
    {
        return $this->getConfig(ConfigData::PAYMENTFEE_MINORDER_XML_PATH);
    }

    /**
     * Get paymentfee title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getConfig(ConfigData::PAYMENTFEE_TITLE_XML_PATH);
    }

    /**
     * Get paymentfee price type
     *
     * @return bool
     */
    public function getPriceType()
    {
        return $this->getConfig(ConfigData::PAYMENTFEE_PRICETYPE_XML_PATH);
    }

    /**
     * Get allowed customer group
     *
     * @return bool
     */
    public function getAllowedCustomerGroup()
    {
        return $this->getConfig(ConfigData::PAYMENTFEE_CUSTOMERS_XML_PATH);
    }

    /**
     * Get default fee
     *
     * @return number
     */
    public function getDefaultFee()
    {
        return $this->getConfig(ConfigData::PAYMENTFEE_DEFAULT_FEE_XML_PATH);
    }

    /**
     * Get allowed customer group
     *
     * @return bool
     */
    public function canApplyCustomer()
    {
        $allowedCustomers = explode(',', $this->getAllowedCustomerGroup());
        $customerId = $this->customerSession->getCustomer()->getGroupId();
        if(in_array($customerId, $allowedCustomers)) {
            return true;
        }
        return false;
    }

    /**
     * Get payment fees
     *
     * @return array
     */
    public function _getPaymentFee()
    {
        $paymentFees = $this->getConfig(ConfigData::PAYMENTFEE_AMOUNT_XML_PATH);
        if($paymentFees) {
            $fees = $this->serialize->unserialize($paymentFees);
            if (is_array($fees)) {
                foreach ($fees as $fee) {
                    $this->methodFee[$fee['payment_method']] = array(
                        'fee' => $fee['fee']
                    );
                }
            }
        }
        return $this->methodFee;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @return bool
     */
    public function canApply(\Magento\Quote\Model\Quote $quote)
    {
        if ($this->isEnable()) {
            if ($method = $quote->getPayment()->getMethod()) {
                if (isset($this->methodFee[$method])) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @return float|int
     */
    public function getFee(\Magento\Quote\Model\Quote $quote)
    {
        $method  = $quote->getPayment()->getMethod();
        $fee = $this->methodFee[$method]['fee'];
        return $fee;
    }
}