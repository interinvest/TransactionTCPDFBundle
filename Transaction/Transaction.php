<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;
use InterInvest\TransactionTCPDFBundle\Transaction\Action;

/**
 * Class Transaction
 *
 * @package InterInvest\TransactionTCPDFBundle\Transaction
 *
 * @method Transaction line($options)
 * @method Transaction textColor($options)
 * @method Transaction textSize($options)
 * @method Transaction html($options)
 */
class Transaction implements TransactionInterface
{
    protected $actions;
    protected $options;

    public function __construct(TCPDFLib $pdf = null)
    {
        $this->actions = New Action\ActionCollection();
        $this->pdf = $pdf;
        $this->options['break'] = true;
    }

    public function __call($name, $arguments)
    {
        if (class_exists(__NAMESPACE__ . '\Action\\' . ucfirst($name) . 'Action')) {
            $className = __NAMESPACE__ . '\Action\\' . ucfirst($name) . 'Action';
            $action = new $className();
            $this->add($action, isset($arguments[0]) ? $arguments[0] : null);
        }

        return $this;
    }

    /**
     * Ajoute une ActionInterface à une ActionCollection
     *
     * @param      $action
     * @param null $options
     *
     * @throws \Exception
     *
     * @return Transaction
     */
    public function add($action, $options = null)
    {
        if (\is_string($action)) {
            if (\class_exists(__NAMESPACE__ . '\Action\\' . ucfirst($action) . 'Action')) {
                $className = __NAMESPACE__ . '\Action\\' . \ucfirst($action) . 'Action';
                $action = new $className($options);
            } else if (($method = 'get' . \ucfirst($action)) && \method_exists($this->pdf, $method)) {
                $action = $this->pdf->$method($options);
            }
        }

        if ($action instanceof ElementInterface) {
            if ($options) {
                $action->setOptions($options);
            }
            $this->actions->add($action);
        } else {
            throw new \Exception('Une action doit être de type ActionInterface');
        }

        return $this;
    }

    /**
     * @return Action\ActionCollection
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param TCPDFLib $pdf
     *
     * @return TCPDFLib
     * @throws \Exception
     */
    public function execute(TCPDFLib $pdf = null)
    {
        $this->init();

        if (!$pdf) {
            $pdf = $this->pdf;
        }

        $pdf->execute($this);

        return $pdf;
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {

    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
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

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getOption($key)
    {
        return isset($this->options[$key]) ? $this->options[$key] : null;
    }
}
