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

namespace Prince\Paymentfee\Model\Creditmemo\Total;

use Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal;

/**
 * Class Fee
 * @package Prince\Paymentfee\Model\Creditmemo\Total
 */
class Fee extends AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Creditmemo $creditmemo
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Creditmemo $creditmemo)
    {
        $creditmemo->setPaymentFee(0);
        $creditmemo->setBasePaymentFee(0);
        $amount = $creditmemo->getOrder()->getPaymentFee();
        $creditmemo->setPaymentFee($amount);
        $amount = $creditmemo->getOrder()->getBasePaymentFee();
        $creditmemo->setBasePaymentFee($amount);
        $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $creditmemo->getPaymentFee());
        $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $creditmemo->getBasePaymentFee());

        return $this;
    }
}
