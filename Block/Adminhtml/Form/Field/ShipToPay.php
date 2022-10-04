<?php

namespace Jqode\ShippingToPayment\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray,
    Jqode\ShippingToPayment\Block\Adminhtml\Form\Field\Payment,
    Jqode\ShippingToPayment\Block\Adminhtml\Form\Field\Shipping;

class ShipToPay extends AbstractFieldArray
{
    /** @var Shipping */
    protected $shippingRenderer;

    /** @var Payment */
    protected $paymentRenderer;

    protected function _prepareToRender()
    {
        $this->addColumn(
            'shipping',
            [
                'label' => __('Shipping method'),
                'class' => 'required-entry',
                'renderer' => $this->getShippingRenderer()
            ]
        );
        $this->addColumn(
            'payment',
            [
                'label' => __('Payment method'),
                'class' => 'required-entry',
                'renderer' => $this->getPaymentRenderer()
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add option');
    }

    protected function getShippingRenderer(): Shipping
    {
        if (null === $this->shippingRenderer) {
            $this->shippingRenderer = $this->getLayout()->createBlock(Shipping::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->shippingRenderer;
    }

    protected function getPaymentRenderer(): Payment
    {
        if (null === $this->paymentRenderer) {
            $this->paymentRenderer = $this->getLayout()->createBlock(Payment::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->paymentRenderer;
    }

    /**
     * @param DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $options = [];

        $options['option_' . $this->getShippingRenderer()->calcOptionHash($row->getData('shipping'))]
            = 'selected="selected"';

        $options['option_' . $this->getPaymentRenderer()->calcOptionHash($row->getData('payment'))]
            = 'selected="selected"';

        $row->setData('option_extra_attrs', $options);
    }
}
