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

namespace Prince\Paymentfee\Model\Total;

use Prince\Extrafee\Model\Config\Source\PriceType;

/**
 * Class Fee
 * @package Prince\Paymentfee\Model\Total
 */
class Fee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Quote\Model\QuoteValidator
     */
    protected $quoteValidator = null;

    /**
     * @var \Prince\Paymentfee\Helper\Data
     */
    protected $_helper;

    /**
     * @param \Magento\Quote\Model\QuoteValidator $quoteValidator
     * @param \Prince\Paymentfee\Helper\Data $helper
     */
    public function __construct(
        \Magento\Quote\Model\QuoteValidator $quoteValidator,
        \Prince\Paymentfee\Helper\Data $helper
    ) {
        $this->quoteValidator = $quoteValidator;
        $this->_helper = $helper;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        if ($this->_getAddress()->getAddressType() == 'shipping') {
            $enabled = $this->_helper->isEnable();
            $minOrderTotal = $this->_helper->getMinOrderTotal();
            $subTotal = $quote->getSubtotal();
            $fee = 0;

            if ($enabled && $minOrderTotal >= $subTotal) {
                $canApplyCustomer = $this->_helper->canApplyCustomer();
                $canApply = $this->_helper->canApply($quote);
                $fee = $this->_helper->getDefaultFee();

                if ($canApply && $canApplyCustomer) {
                    $fee = $this->_helper->getFee($quote);
                    switch ($this->_helper->getPriceType()) {
                        case PriceType::TYPE_PERCENTAGE:
                            $fee = ($subTotal * $fee) / 100;
                            break;
                        case PriceType::TYPE_PER_ROW:
                            $fee = $fee * \count($quote->getAllVisibleItems());
                            break;
                        case PriceType::TYPE_PER_ITEM:
                            $fee = $fee * $quote->getItemsQty();
                            break;
                    }
                }
            }

            $total->setTotalAmount('payment_fee', $fee);
            $total->setPaymentFee($fee);
            $total->setBasePaymentFee($fee);
            $quote->setPaymentFee($fee);
            $quote->setBasePaymentFee($fee);
            $total->setBaseGrandTotal($total->getBaseGrandTotal() + $fee);
        }
        return $this;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $result = [
            'code' => 'payment_fee',
            'title' => $this->getLabel(),
            'value' => $total->getPaymentFee()
        ];

        return $result;
    }

    /**
     * Get label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __($this->_helper->getTitle());
    }
}
