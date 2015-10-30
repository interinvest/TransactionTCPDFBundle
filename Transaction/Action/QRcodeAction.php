<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class QRcodeAction extends AbstractAction implements ActionInterface
{
    protected $options;

    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        $qrcode = isset($this->options['qrcode']) ? $this->options['qrcode'] : array(0, 0, 0);
        $x = isset($this->options['x']) ? $this->options['x'] : '';
        $y = isset($this->options['y']) ? $this->options['y'] : '';
        $w = isset($this->options['w']) ? $this->options['w'] : 15;
        $h = isset($this->options['h']) ? $this->options['h'] : 15;

        $pdf->write2DBarcode($qrcode, 'QRCODE', $x, $y, $w, $h);
    }
}
