<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class SvgAction extends AbstractAction implements ActionInterface
{
    protected $options;

    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        $url = isset($this->options['url']) ? $this->options['url'] : 0;
        $w = isset($this->options['w']) ? $this->options['w'] : 0;
        $h = isset($this->options['h']) ? $this->options['h'] : 0;
        $x = isset($this->options['x']) ? $this->options['x'] : $pdf->GetX();
        $y = isset($this->options['y']) ? $this->options['y'] : $pdf->GetY();

        if (isset($this->options['url'])) {
            $pdf->ImageSVG($url, $x, $y, $w, $h);
            if ($h) {
                $pdf->SetY($pdf->GetY() + $h);
            }
        }
    }
}
