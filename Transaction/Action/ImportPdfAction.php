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

        $autoPageBreak = $pdf->getAutoPageBreak();
        $pdf->SetAutoPageBreak(false);
        for ($i = 1; $i <= $nbPage; $i++) {
            $tplIdx = $pdf->importPage($i);
            $pdf->AddPage($orientation);
            $pdf->useTemplate($tplIdx);
        }
        $pdf->SetAutoPageBreak($autoPageBreak);
    }
}