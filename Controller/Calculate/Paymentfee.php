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

namespace Prince\Paymentfee\Controller\Calculate;

use Magento\Framework\App\Action\Context;
use Magento\Checkout\Model\Session;

class Paymentfee extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJson;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * Paymentfee constructor.
     * @param Context $context
     * @param Session $checkoutSession
     * @param \Magento\Framework\Json\Helper\Data $helper
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJson
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     */
    public function __construct(
        Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Json\Helper\Data $helper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJson,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    ) {
        parent::__construct($context);
        $this->_checkoutSession = $checkoutSession;
        $this->_helper = $helper;
        $this->_resultJson = $resultJson;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $response = [
            'errors' => false,
            'message' => 'Re-calculate successful.'
        ];

        try {
            $this->quoteRepository->get($this->_checkoutSession->getQuoteId());
            $quote = $this->_checkoutSession->getQuote();
            $payment = $this->_helper->jsonDecode($this->getRequest()->getContent());
            $this->_checkoutSession->getQuote()->getPayment()->setMethod($payment['payment']);
            $this->quoteRepository->save($quote->collectTotals());
        } catch (\Exception $e) {
            $response = [
                'errors' => true,
                'message' => $e->getMessage()
            ];
        }

        $resultJson = $this->_resultJson->create();

        return $resultJson->setData($response);
    }
}
