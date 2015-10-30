<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class PositionAction extends AbstractAction implements ActionInterface
{
    protected $options;

    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        if (isset($this->options['x'])) {
            $pdf->SetX($this->options['x']);
        }
        if (isset($this->options['y'])) {
            $pdf->SetY($this->options['y']);
        }
        if (isset($this->options['offsetX'])) {
            $pdf->SetX($pdf->GetX() + $this->options['offsetX']);
        }
        if (isset($this->options['offsetY'])) {
            $pdf->SetY($pdf->GetY() + $this->options['offsetY']);
        }
    }
}
