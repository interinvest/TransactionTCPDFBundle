<?php

namespace InterInvest\TransactionTCPDFBundle\Lib;

use InterInvest\TransactionTCPDFBundle\Transaction\ElementInterface;
use InterInvest\TransactionTCPDFBundle\Transaction\Transaction;
use InterInvest\TransactionTCPDFBundle\Transaction\Action;
use FPDI;

class TCPDFLib extends FPDI
{
    public $footerTransaction = null;
    protected $footerPrintLine = false;
    public $footerOffset = 30;
    protected $rollbackSave = null;
    public $printFooter = true;

    public $footerPrinted = array();

    public $tableStyles = array();
    public $tableHeadStyles = array();
    public $tableBodyStyles = array();
    public $tableFootStyles = array();

    protected function init()
    {
        $this->header_line_color = array(255, 255, 255);
        $this->bMargin = $this->footerOffset;
    }

    /**
     * This method is used to render the page footer.
     * It is automatically called by AddPage() and could be overwritten in your own inherited class.
     *
     * @public
     */
    public function Footer()
    {
        $this->SetY($this->GetY() - $this->footerOffset);
        if ($this->footerTransaction instanceof Transaction && $this->printFooter && !isset($this->footerPrinted[$this->getPage()])) {
            $this->execute($this->footerTransaction);
            $this->footerPrinted[$this->getPage()] = true;
        }
    }

    public function __construct()
    {
        parent::__construct();

        $this->init();
    }

    public function addTable($body, $head = null, $foot = null)
    {
        $bodyStyles = $this->tableBodyStyles;
        if (!isset($body['rows'])) {
            $body = array('styles' => array(), 'rows' => $body);
        }
        foreach ($bodyStyles as $key => $style) {
            if (!isset($body['styles'][$key])) {
                $body['styles'][$key] = $style;
            }
        }

        if ($head) {
            $headStyles = $this->tableHeadStyles;
            if (!isset($head['rows'])) {
                $head = array('styles' => array(), 'rows' => $head);
            }
            foreach ($headStyles as $key => $style) {
                if (!isset($head['styles'][$key])) {
                    $head['styles'][$key] = $style;
                }
            }
        }

        if ($foot) {
            $footStyles = $this->tableFootStyles;
            if (!isset($foot['rows'])) {
                $foot = array('styles' => array(), 'rows' => $foot);
            }
            foreach ($footStyles as $key => $style) {
                if (!isset($foot['styles'][$key])) {
                    $foot['styles'][$key] = $style;
                }
            }
        }

        $table = array(
            'table' => array(
                'styles' => $this->tableStyles,
                'head'   => $head,
                'body'   => $body,
                'foot'   => $foot,
            ),
        );

        $transaction = new Transaction($this);
        $transaction->setOption('break', false);
        $transaction->add('table', $table);

        return $transaction;
    }

    /**
     * @return Transaction
     */
    public function transaction()
    {
        return new Transaction($this);
    }

    /**
     * Execute la transaction $transaction
     *
     * @param Transaction $transaction
     *
     * @return $this
     */
    public function execute(Transaction $transaction)
    {
        $page = $this->getNumPages();

        if ($transaction->getOption('break')) {
            $this->startTransaction();
        }
        foreach ($transaction->getActions() as $element) {
            if ($element instanceof ElementInterface) {
                $element->execute($this);
            }
        }

        if ($transaction->getOption('break')) {
            if ($page < $this->getNumPages()) {
                $this->rollbackTransaction(true);
                $this->AddPage();
                $transaction->setOption('break', false);
                $this->execute($transaction);
            }
        }

        if ($transaction->getOption('break')) {
            $this->commitTransaction();
        }

        return $this;
    }

}
