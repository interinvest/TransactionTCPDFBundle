<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

abstract class AbstractAction implements ActionInterface
{
    protected $options;

    public function __construct($options = null)
    {
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getOption($key)
    {
        return isset($this->options[$key]) ? $this->options[$key] : null;
    }
}
