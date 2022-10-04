<?php

namespace Jqode\ShippingToPayment\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Payment\Model\Config\Source\Allmethods;

class Payment extends Select
{
    private $allmethods;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        Allmethods $allmethods,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->allmethods = $allmethods;
    }

    /**
     * {@inheritdoc}
     */
    protected function _toHtml()
    {
        if (true === empty($this->getOptions())) {
            $this->setOptions($this->allmethods->toOptionArray());
        }

        return parent::_toHtml();
    }

    public function setInputName(string $value): self
    {
        return $this->setName($value);
    }
}
