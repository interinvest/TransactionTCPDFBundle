<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class PaginateAction extends HtmlAction implements ActionInterface
{
    public function __construct($options = array())
    {
        parent::__construct($options);
    }

    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        $this->options['html'] = $pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages();

        parent::execute($pdf);
    }
}
