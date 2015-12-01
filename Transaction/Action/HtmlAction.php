<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class HtmlAction extends AbstractAction implements ActionInterface
{
    protected $options;

    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        $border = isset($this->options['border']) ? $this->options['border'] : 0;
        $ln = isset($this->options['ln']) ? $this->options['ln'] : 1;
        $fill = isset($this->options['fill']) ? $this->options['fill'] : false;
        $fillColor = isset($this->options['fillColor']) ? $this->options['fillColor'] : null;
        $borderColor = isset($this->options['borderColor']) ? $this->options['borderColor'] : null;
        $reseth = isset($this->options['reseth']) ? $this->options['reseth'] : true;
        $align = isset($this->options['align']) ? $this->options['align'] : 'J';
        $autopadding = isset($this->options['autopadding']) ? $this->options['autopadding'] : true;
        $valign = isset($this->options['valign']) ? $this->options['valign'] : 'T';
        $isHtml = isset($this->options['isHtml']) ? $this->options['isHtml'] : true;
        $w = isset($this->options['w']) ? $this->options['w'] : '';
        $h = isset($this->options['h']) ? $this->options['h'] : '';
        $x = isset($this->options['x']) ? $this->options['x'] : '';
        $y = isset($this->options['y']) ? $this->options['y'] : '';

        if ($fillColor) {
            $pdf->SetFillColorArray($fillColor);
        }
        if ($borderColor) {
            $pdf->SetDrawColorArray($borderColor);
        }

        if (isset($this->options['html'])) {
//            $pdf->writeHTMLCell($w, $h, $x, $y, $this->options['html'], $border, $ln, $fill, $reseth, $align, $autopadding);
            $pdf->MultiCell($w, $h, $this->options['html'], $border, $align, $fill, $ln, $x, $y, $reseth, 0, $isHtml, $autopadding, $h, $valign, false);
        }
    }
}
