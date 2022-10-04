<?php

namespace Jqode\ShippingToPayment\Helper;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\Helper\Context;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    private const CONFIG_PATH_SHIPPING_TO_PAYMENT_IS_ACTIVE = 'carriers/shipping_to_payment/is_active';
    private const CONFIG_PATH_SHIPPING_TO_PAYMENT_OPTIONS = 'carriers/shipping_to_payment/ship_to_pay';

    /** @var Json */
    private $serializer;

    public function __construct(
        Context $context,
        Json $serializer
    ) {
        parent::__construct($context);
        $this->serializer = $serializer;
    }

    public function getIsActive(): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_SHIPPING_TO_PAYMENT_IS_ACTIVE);
    }

    public function getShippingToPaymentOptions(): array
    {
        $values = $this->scopeConfig->getValue(self::CONFIG_PATH_SHIPPING_TO_PAYMENT_OPTIONS);

        if (true === empty($values)) {
            return [];
        }

        $options = [];

        foreach ($this->serializer->unserialize($values) as $value) {
            $options[$value['shipping']][] = $value['payment'];
        }

        return $options;
    }
}
