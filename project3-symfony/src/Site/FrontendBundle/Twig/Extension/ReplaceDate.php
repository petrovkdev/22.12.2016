<?php

namespace Site\FrontendBundle\Twig\Extension;


class ReplaceDate extends \Twig_Extension
{
    public function getName()
    {
        return 'twig.replace_date';
    }
    public function getFilters()
    {
        return array(
            'replace_date'   => new \Twig_Filter_Method($this, 'replaceDate')
        );
    }
    public function replaceDate($string)
    {
        $year = date('Y');
        return str_replace($year, '', $string);
    }
}