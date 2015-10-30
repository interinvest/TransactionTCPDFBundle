<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction;

class QRcodeTransaction extends Transaction implements TransactionInterface
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $qrcode = $this->options['qrcode'];
        $y = isset($this->options['y']) ? $this->options['y'] : '';
        $textColor = isset($this->options['textColor']) ? $this->options['textColor'] : array(0, 0, 0);

        $this
            ->add('qRcode', array('qrcode' => $qrcode, 'y' => $y, 'h' => 15, 'w' => 15))
            ->add('textOptions', array('color' => $textColor, 'size' => 6))
            ->add('html', array('html' => $qrcode, 'y' => $y+15))
        ;
    }
}
