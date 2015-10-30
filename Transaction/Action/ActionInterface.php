<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;
use InterInvest\TransactionTCPDFBundle\Transaction\ElementInterface;

interface ActionInterface extends ElementInterface
{
    /**
     * Construct
     *
     * @param array $options
     */
    public function __construct($options = array());

    /**
     * Execute action
     *
     * @param TCPDFLib $pdf
     */
    public function execute(TCPDFLib $pdf);

    /**
     * Set les options d'une Action
     *
     * @param array $params
     */
    public function setOptions(array $params);

    /**
     * Get les options d'une Action
     *
     * @return array
     */
    public function getOptions();
}
