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

namespace Prince\Paymentfee\Model\Config\Source;

class ActiveMethods
{
    /**
     * @var \Magento\Payment\Model\Config
     */
    protected $paymentConfig;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * ActiveMethods constructor.
     * @param \Magento\Payment\Model\Config $config
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Payment\Model\Config $config,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->paymentConfig = $config;
        $this->scopeConfig = $scopeConfig;
    }

    protected function _getPaymentMethods()
    {
        return $this->paymentConfig->getActiveMethods();
    }

    public function toOptionArray()
    {
        $methods = [['value'=>'', 'label'=>'']];
        $payments = $this->_getPaymentMethods();

        foreach ($payments as $paymentCode => $paymentModel) {
            $paymentTitle = $this->scopeConfig->getValue('payment/'.$paymentCode.'/title');
            $methods[$paymentCode] = [
                'label'   => $paymentTitle,
                'value' => $paymentCode
            ];
        }
        return $methods;
    }
}
