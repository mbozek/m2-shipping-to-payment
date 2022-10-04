<?php

namespace Jqode\ShippingToPayment\Model\Checks;

use Jqode\ShippingToPayment\Helper\Config;

use Magento\Payment\Model\MethodInterface;
use Magento\Quote\Model\Quote;
use Magento\Payment\Model\Checks\SpecificationInterface;

class Shipping implements SpecificationInterface
{
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param MethodInterface $paymentMethod
     * @param \Magento\Quote\Model\Quote $quote
     * @return bool
     */
    public function isApplicable(MethodInterface $paymentMethod, Quote $quote)
    {
        if (false === $this->config->getIsActive()) {
            return true;
        }

        $shippingToPaymentOptions = $this->config->getShippingToPaymentOptions();

        if (true === empty($shippingToPaymentOptions)) {
            return true;
        }

        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();

        if (true === array_key_exists($shippingMethod, $shippingToPaymentOptions)
            && true === in_array($paymentMethod->getCode(), $shippingToPaymentOptions[$shippingMethod]))
        {
            return true;
        }

        return false;
    }
}
