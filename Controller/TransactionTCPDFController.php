<?php
namespace InterInvest\TransactionTCPDFBundle\Controller;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;
use ReflectionClass;
use \TCPDF;

class TransactionTCPDFController
{
    protected $layouts;
    protected $className;

    /**
     * Class constructor
     *
     * @param string $className The class name to use. Default is TCPDF. Must be based on TCPDF
     */
    public function __construct($layout)
    {
        $this->layouts = $layout;
    }

    /**
     * Creates a new instance of TCPDF/the class name to use as supplied
     * Any arguments passed here will be passed directly
     * to the TCPDF class as constructor arguments
     *
     * @param string $layout
     *
     * @return TCPDF
     * @throws \Exception
     */
    public function create($layout = null)
    {
        if (!$layout) {
            $layout = \key($this->layouts);
        }

        if (!isset($this->layouts[$layout])) {
            throw new \Exception('The layout "'.$layout.'" cannot be found.');
        }

        $layoutOptions = $this->layouts[$layout];
        $className = $layoutOptions['class'];

        $rc = new ReflectionClass($className);
        $tcpdfLib = $rc->newInstanceArgs(func_get_args());

        if (!($tcpdfLib instanceof TCPDFLib)) {
            throw new \LogicException("Class '{$className}' must inherit from TCPDFLib");
        }

        return ;
    }

}