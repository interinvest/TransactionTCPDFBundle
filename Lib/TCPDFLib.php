<?php

namespace InterInvest\TransactionTCPDFBundle\Lib;

use InterInvest\TransactionTCPDFBundle\Transaction\ElementInterface;
use InterInvest\TransactionTCPDFBundle\Transaction\Transaction;
use InterInvest\TransactionTCPDFBundle\Transaction\Action;
use FPDI;

class TCPDFLib extends FPDI
{
    protected $footerTransaction = null;
    protected $footerPrintLine = false;
    protected $footerOffset = 30;
    protected $rollbackSave = null;
    public $printFooter = true;

    public $tableStyles = array();
    public $tableHeadStyles = array();
    public $tableBodyStyles = array();
    public $tableFootStyles = array();

    protected function init()
    {
        $this->header_line_color = array(255, 255, 255);
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
        $cur_y = $this->y;
        $this->SetTextColorArray($this->footer_text_color);
        //set style for cell border
        $line_width = (0.85 / $this->k);
        if ($this->footerPrintLine) {
            $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
        }
        //print document barcode
        $barcode = $this->getBarcode();
        if (!empty($barcode)) {
            $this->Ln($line_width);
            $style = array(
                'position'     => $this->rtl ? 'R' : 'L',
                'align'        => $this->rtl ? 'R' : 'L',
                'stretch'      => false,
                'fitwidth'     => true,
                'cellfitalign' => '',
                'border'       => false,
                'padding'      => 0,
                'fgcolor'      => array(0, 0, 0),
                'bgcolor'      => false,
                'text'         => false
            );
            $this->write1DBarcode($barcode, 'C128', '', $cur_y + $line_width, '', (($this->footer_margin / 3) - $line_width), 0.3, $style, '');
        }
        if ($this->footerTransaction instanceof Transaction && $this->printFooter) {
            $this->execute($this->footerTransaction);
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

        return $this->transaction()
            ->add('table', $table)
            ;
    }

    /**
     * @return Transaction
     */
    public function transaction()
    {
        return new Transaction($this);
    }

    /**
     * @param $offset
     */
    public function setPageBreakTrigger($offset)
    {
        $this->PageBreakTrigger = $this->h - $offset;
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
        $this->setPageBreakTrigger($this->footerOffset);

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
