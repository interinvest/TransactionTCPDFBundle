<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;
use TCPDF;

interface ElementInterface
{
    /**
     * Execute action
     *
     * @param TCPDFLib $pdf
     */
    public function execute(TCPDFLib $pdf);

    /**
     * Set les option
     *
     * @param array $params
     */
    public function setOptions(array $params);

    /**
     * Get les options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Set an option
     *
     * @return array
     */
    public function setOption($key, $value);

    /**
     * Get une option
     *
     * @return string
     */
    public function getOption($key);
}
