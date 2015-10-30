<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class TextOptionsAction extends AbstractAction implements ActionInterface
{
    protected $options;

    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        if (isset($this->options['size'])) {
            $pdf->SetFontSize($this->options['size']);
        }
        if (isset($this->options['color'])) {
            $pdf->SetTextColorArray($this->options['color']);
        }
        if (isset($this->options['style'])) {
            $pdf->SetFont($pdf->getFontFamily(), $this->options['style']);
        }
        if (isset($this->options['spacing'])) {
            $pdf->setFontSpacing($this->options['spacing']);
        }
    }
}
