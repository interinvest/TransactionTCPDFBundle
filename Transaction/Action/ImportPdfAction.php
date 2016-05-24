<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class ImportPdfAction extends AbstractAction implements ActionInterface
{
    protected $options;

    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        $nbPage = $pdf->setSourceFile($this->options['file']);
        $orientation = isset($this->options['orientation']) ? $this->options['orientation'] : 'P';
        $x = isset($this->options['x']) ? $this->options['x'] : null;
        $y = isset($this->options['y']) ? $this->options['y'] : null;
        $w = isset($this->options['w']) ? $this->options['w'] : 0;
        $h = isset($this->options['h']) ? $this->options['h'] : 0;
        $adjustPageSize = isset($this->options['adjustPageSize']) ? $this->options['adjustPageSize'] : false;

        $keepFooter = isset($this->options['keepFooter']) ? $this->options['keepFooter'] : true;
        $autoPageBreak = $pdf->getAutoPageBreak();
        $pdf->SetAutoPageBreak(false);
        for ($i = 1; $i <= $nbPage; $i++) {
            $tplIdx = $pdf->importPage($i);
            $pdf->AddPage(is_array($orientation) ? (isset($orientation[$i]) ? $orientation[$i] : 'P') : $orientation);
            if (!$keepFooter) {
                $pdf->footerTransaction = null;
            }
            $pdf->useTemplate($tplIdx, $x, $y, $w, $h, $adjustPageSize);
        }
        $pdf->SetAutoPageBreak($autoPageBreak);
    }
}
