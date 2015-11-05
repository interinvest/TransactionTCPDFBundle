<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class CadreAction extends AbstractAction implements ActionInterface
{
    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        $width  = isset($this->options['width']) ? $this->options['width'] : 4;
        $height = isset($this->options['height']) ? $this->options['height'] : 4;
        $color = isset($this->options['color']) ? $this->options['color'] : array(0, 0, 0);
        $x = isset($this->options['x']) ? $this->options['x'] : $pdf->GetX();
        $y = isset($this->options['y']) ? $this->options['y'] : $pdf->GetY();

        $pdf->SetDrawColorArray($color);
        $pdf->Rect($x, $y, $width, $height);

        return $this;
    }
}