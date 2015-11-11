<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction;

class PresentationTransaction extends Transaction implements TransactionInterface
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $datas = isset($this->options['datas']) ? $this->options['datas'] : array();
        $textTop = isset($this->options['textTop']) ? $this->options['textTop'] : '';
        $textBottom = isset($this->options['textBottom']) ? $this->options['textBottom'] : '';
        $colWidth = isset($this->options['colWidth']) ? $this->options['colWidth'] : array();
        $textColor = isset($this->options['textColor']) ? $this->options['textColor'] : array(130, 130, 130);
        $x = isset($this->options['x']) ? $this->options['x'] : 15;
        $spaced = isset($this->options['spaced']) ? $this->options['spaced'] : 0;

        if ($textTop) {
            $this->add('html', array('html' => $textTop, 'ln' => 0, 'x' => $x));
            $this->add('position', array('offsetY' => 4));
        }

        foreach ($datas as $keys => $values) {
            $i = 0;
            $totalWidth = 0;
            foreach ($values as $key => $value) {
                if ($i == 0) {
                    $this->add('html', array('html' => '<b>' . $value . '</b>', 'w' => $colWidth[$key], 'ln' => 0, 'x' => $x));
                } else {
                    $this->add('html', array('html' => $value, 'w' => $colWidth[$key], 'ln' => (count($values) - 1 == $i) ? 1 : 0));
                }
                $i++;
                $totalWidth += $colWidth[$key];
            }
            $this->add('line', array('borderColor' => $textColor, 'w' => $totalWidth, 'ln' => 1, 'x' => $x));
            $this->add('position', array('offsetY' => $spaced));
        }

        if ($textBottom) {
            $this->add('position', array('offsetY' => 2));
            $this->add('html', array('html' => $textBottom, 'ln' => 1, 'x' => $x));
        }
    }
}