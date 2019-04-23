<?php
namespace Prince\Paymentfee\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Session as CheckoutSession;

class AddPaymentfeeItem implements ObserverInterface
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * AddExtrafeeItem constructor.
     * @param CheckoutSession $checkoutSession
     */
    public function __construct(CheckoutSession $checkoutSession)
    {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Add custom amount as custom item to payment cart totals.
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $cart = $observer->getEvent()->getCart();
        $quote = $this->checkoutSession->getQuote();
        $cart->addCustomItem(__('Payment Fee'), 1, $quote->getPaymentFee(), 'paymentfee');
    }
}