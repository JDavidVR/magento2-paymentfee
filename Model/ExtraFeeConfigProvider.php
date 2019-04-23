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

namespace Prince\Paymentfee\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

/**
 * Class ExtraFeeConfigProvider
 * @package Prince\Paymentfee\Model
 */
class ExtraFeeConfigProvider implements ConfigProviderInterface
{
    /**
     * @var \Prince\Paymentfee\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Prince\Paymentfee\Helper\Data $helper
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        \Prince\Paymentfee\Helper\Data $helper,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->_helper = $helper;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $extraFeeConfig = [];
        $enabled = $this->_helper->isEnable();
        $isShowZeroPaymentFee = $this->_helper->isShowZeroPaymentFee();
        $isDescription = $this->_helper->isDescription();
        $description = $this->_helper->getDescription();
        $minOrderTotal = $this->_helper->getMinOrderTotal();
        //$extraFeeConfig['fee_title'] = $this->_helper->getTitle();
        $extraFeeConfig['fee_description'] = ($enabled && $isDescription) ? $description : false;
        $extraFeeConfig['show_zero_fee'] = ($enabled && $isShowZeroPaymentFee) ? true : false;
        $quote = $this->checkoutSession->getQuote();
        $subTotal = $quote->getSubtotal();
        //$priceType = $this->_helper->getPriceType();
        //$extraFeeAmount = 0;
        //if ($priceType) {
        //    $extraFeeAmount = ($subTotal * $extraFeeAmount) / 100;
        //}
        //$extraFeeConfig['extra_fee_amount'] = $extraFeeAmount;
        $extraFeeConfig['show_hide_paymentfee'] = ($enabled && ($minOrderTotal >= $subTotal) && $quote->getPaymentFee()) ? true : false;
        return $extraFeeConfig;
    }
}
