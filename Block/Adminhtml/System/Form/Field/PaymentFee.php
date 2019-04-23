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

class PaymentFee extends  \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    protected $_columns = [];

    /**
     * @var Methods
     */
    protected $_typeRenderer;

    protected $_searchFieldRenderer;

    /**
     * @var \Prince\Paymentfee\Model\Config\ActiveMethods
     */
    protected $activeMethods;

    /**
     * PaymentFee constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Prince\Paymentfee\Model\Config\Source\ActiveMethods $activeMethods
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Prince\Paymentfee\Model\Config\Source\ActiveMethods $activeMethods,
        array $data = []
    ) {
        $this->activeMethods = $activeMethods;
        parent::__construct($context, $data);
    }


    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->_typeRenderer        = null;
        $this->_searchFieldRenderer = null;

        $this->addColumn(
            'payment_method',
            ['label' => __('Payment Method'), 'renderer' => $this->_getPaymentRenderer()]
        );

        $this->addColumn('fee', ['label' => __('Fee')]);
        $this->_addAfter       = false;
        $this->_addButtonLabel = __('Add Fee');
    }


    /**
     * Retrieve active payment methods renderer
     *
     * @return Methods
     */
    protected function _getPaymentRenderer() {

        if (!$this->_typeRenderer) {
            $this->_typeRenderer = $this->getLayout()->createBlock(
                'Prince\Paymentfee\Block\Adminhtml\System\Form\Field\Methods',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->_typeRenderer->setClass('payemtfee_select');
        }
        return $this->_typeRenderer;
    }

    /**
     * Prepare existing row data object
     *
     * @param \Magento\Framework\DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row) {

        $optionExtraAttr = [];
        $optionExtraAttr['option_' . $this->_getPaymentRenderer()->calcOptionHash($row->getData('payment_method'))] =
            'selected="selected"';
        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }
}
