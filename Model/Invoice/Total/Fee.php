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

namespace Prince\Paymentfee\Model\Invoice\Total;

use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

/**
 * Class Fee
 * @package Prince\Paymentfee\Model\Invoice\Total
 */
class Fee extends AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $invoice->setPaymentFee(0);
        $invoice->setBasePaymentFee(0);
        $amount = $invoice->getOrder()->getPaymentFee();
        $invoice->setPaymentFee($amount);
        $amount = $invoice->getOrder()->getBasePaymentFee();
        $invoice->setBasePaymentFee($amount);
        $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getPaymentFee());
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getPaymentFee());

        return $this;
    }
}
