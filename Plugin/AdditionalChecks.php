<?php

namespace Jqode\ShippingToPayment\Plugin;

use Magento\Payment\Model\Checks\SpecificationFactory;

class AdditionalChecks
{
    private $additionalChecks;

    public function __construct(array $additionalChecks = [])
    {
        $this->additionalChecks = $additionalChecks;
    }

    public function beforeCreate(SpecificationFactory $subject, array $checks): array
    {
        $checks = array_merge(
            $checks,
            $this->additionalChecks
        );

        return [ $checks ];
    }
}
