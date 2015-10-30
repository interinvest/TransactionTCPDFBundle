<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class CheckboxAction extends HtmlAction implements ActionInterface
{
    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        $html = isset($this->options['html']) ? $this->options['html'] : null;
        $size = isset($this->options['size']) ? $this->options['size'] : 4;
        $color = isset($this->options['color']) ? $this->options['color'] : array(0, 0, 0);
        $checked = isset($this->options['checked']) ? $this->options['checked'] : false;
        $x = isset($this->options['x']) ? $this->options['x'] : $pdf->GetX() + 1;
        $y = isset($this->options['y']) ? $this->options['y'] : $pdf->GetY();

        $pdf->SetDrawColorArray($color);
        $pdf->Rect($x, $y, $size, $size);
        if ($checked) {
            $pdf->Line($x, $y, $x + $size, $y + $size);
            $pdf->Line($x, $y + $size, $x + $size, $y);
        }
        $pdf->SetX($x + $size + 1);

        if ($html) {
            $this->options['x'] = $pdf->GetX();
            parent::execute($pdf);
        }

        return $this;
    }
}
