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

namespace Prince\Paymentfee\Block\Adminhtml\System\Form\Field;

class Methods extends \Magento\Framework\View\Element\Html\Select
{
    /**
     * Payment methods cache
     *
     * @var array
     */
    private $methods;

    /**
     * @var \Magento\Payment\Model\Config
     */
    protected $paymentConfig;

    /**
     * Methods constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Payment\Model\Config $config
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Payment\Model\Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->paymentConfig = $config;

    }

    protected function _getPaymentMethods()
    {
        if($this->methods === null) {
            $this->methods = $this->paymentConfig->getActiveMethods();
        }
        return $this->methods;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            foreach ($this->_getPaymentMethods() as $paymentCode => $paymentModel) {
                $paymentTitle = $this->_scopeConfig->getValue('payment/'.$paymentCode.'/title');
                $this->addOption($paymentCode, addslashes($paymentTitle));
            }
        }
        return parent::_toHtml();
    }
}
