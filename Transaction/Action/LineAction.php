<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class LineAction extends HtmlAction implements ActionInterface
{
    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        $color = isset($this->options['color']) ? $this->options['color'] : array(0, 0, 0);

        $pdf->SetDrawColorArray($color);
        $this->options['html'] = '<hr/>';
        parent::execute($pdf);
    }
}
