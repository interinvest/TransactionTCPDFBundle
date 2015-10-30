<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

interface TransactionInterface extends ElementInterface
{
    /**
     * Execute action
     *
     * @param TCPDFLib $pdf
     */
    public function execute(TCPDFLib $pdf = null);

    /**
     * Set les options
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
     * Get une option
     *
     * @return string
     */
    public function getOption($key);

    /**
     * Inititialise une transaction
     */
    public function init();
}
