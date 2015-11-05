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
        $x = isset($this->options['x']) ? $this->options['x'] : '';
        $w = isset($this->options['w']) ? $this->options['w'] : 15;
        $h = isset($this->options['h']) ? $this->options['h'] : 15;
        $textColor = isset($this->options['textColor']) ? $this->options['textColor'] : array(0, 0, 0);

        $this
            ->add('qRcode', array('qrcode' => $qrcode, 'y' => $y, 'x' => $x, 'h' => $h, 'w' => $w))
            ->add('textOptions', array('color' => $textColor, 'size' => 6))
            ->add('html', array('html' => $qrcode, 'y' => $y + $h, 'x' => $x))
        ;
    }
}