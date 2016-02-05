<?php

namespace InterInvest\TransactionTCPDFBundle\Transaction\Action;

use InterInvest\TransactionTCPDFBundle\Lib\TCPDFLib;

class TableAction extends HtmlAction implements ActionInterface
{
    protected $html = '';

    public function addHtmlCol($value, $colStyles, $rowStyles, $blockStyles, $tableStyles, $even = true)
    {
        $this->html .= '<td';

        $options = array('rowspan', 'colspan', 'align', 'valign', 'width');
        foreach ($options as $option) {
            if (isset($colStyles[$option])) {
                $this->html .= ' ' . $option . '="' . $colStyles[$option] . '"';
            } elseif (isset($rowStyles[$option])) {
                $this->html .= ' ' . $option . '="' . $rowStyles[$option] . '"';
            } elseif (isset($blockStyles[$option])) {
                $this->html .= ' ' . $option . '="' . $blockStyles[$option] . '"';
            } elseif (isset($tableStyles[$option])) {
                $this->html .= ' ' . $option . '="' . $tableStyles[$option] . '"';
            }
        }

        $this->html .= ' style="';
        $styles = array('background-color-even', 'background-color-odd');
        foreach ($styles as $style) {
            if (isset($blockStyles[$style])) {
                if ($style == 'background-color-even' && $even) {
                    $this->html .= ' background-color: ' . $blockStyles[$style] . ';';
                } elseif ($style == 'background-color-odd' && !$even) {
                    $this->html .= ' background-color: ' . $blockStyles[$style] . ';';
                }
            }
        }
        $styles = array('border', 'background-color', 'height', 'line-height');
        foreach ($styles as $style) {
            if (isset($colStyles[$style])) {
                $this->html .= ' ' . $style . ': ' . $colStyles[$style] . ';';
            } elseif (isset($rowStyles[$style])) {
                $this->html .= ' ' . $style . ': ' . $rowStyles[$style] . ';';
            } elseif (isset($blockStyles[$style])) {
                $this->html .= ' ' . $style . ': ' . $blockStyles[$style] . ';';
            } elseif (isset($tableStyles[$style])) {
                $this->html .= ' ' . $style . ': ' . $tableStyles[$style] . ';';
            }
        }
        $this->html .= '">';

        $opts = array('prepend' => '', 'append' => '');
        foreach ($opts as $key => $opt) {
            if (isset($colStyles[$key])) {
                $opts[$key] = $colStyles[$key];
            } elseif (isset($rowStyles[$key])) {
                $opts[$key] = $rowStyles[$key];
            } elseif (isset($blockStyles[$key])) {
                $opts[$key] = $blockStyles[$key];
            } elseif (isset($tableStyles[$key])) {
                $opts[$key] = $tableStyles[$key];
            }
        }
        $this->html .= $opts['prepend'] . $value . $opts['append'];

        $this->html .= '</td>';
    }

    protected function writeContent($content, $tableStyles)
    {
        $contentStyle = isset($content['styles']) ? $content['styles'] : null;

        $i = 0;
        foreach ($content['rows'] as $row) {
            $rowStyles = isset($row['styles']) ? $row['styles'] : null;
            $cols = isset($row['cols']) ? $row['cols'] : $row;

            $this->html .= '<tr nobr="true">';
            foreach ($cols as $col) {
                $colStyles = isset($col['styles']) ? $col['styles'] : null;
                $value = isset($col['value']) ? $col['value'] : $col;

                $this->addHtmlCol($value, $colStyles, $rowStyles, $contentStyle, $tableStyles, $i % 2);
            }
            $this->html .= '</tr>';
            $i++;
        }
    }

    protected function initTable()
    {
        $table = $this->options['table'];

        $tableOptions = isset($table['styles']) ? $table['styles'] : null;

        $this->html .= '<table';
        $options = array('cellpadding', 'cellspacing');
        foreach ($options as $option) {
            if (isset($tableOptions[$option])) {
                $this->html .= ' ' . $option . '="' . $tableOptions[$option] . '"';
            }
        }
        $this->html .= '>';

        if (isset($table['head'])) {
            $this->html .= '<thead>';
            $this->writeContent($table['head'], $tableOptions);
            $this->html .= '</thead>';
        }
        if (isset($table['body'])) {
            $this->html .= '<tbody>';
            $this->writeContent($table['body'], $tableOptions);
            $this->html .= '</tbody>';
        }
        if (isset($table['foot'])) {
            $this->html .= '<tfoot>';
            $this->writeContent($table['foot'], $tableOptions);
            $this->html .= '</tfoot>';
        }

        $this->html .= '</table>';
    }

    /**
     * {@inheritDoc}
     */
    public function execute(TCPDFLib $pdf)
    {
        $this->initTable();

        $this->options['html'] = $this->html;
        parent::execute($pdf);
    }
}
