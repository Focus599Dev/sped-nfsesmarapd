<?php

namespace NFePHP\NFSe\SMARAPD\Factories;


class Header
{
    /**
     * Return header
     * @param string $namespace
     * @param int $cUF
     * @param string $version
     * @return string
     */
    public static function get($version)
    {
        return "<?xml version=\"1.0\" encoding=\"utf-8\"?>"
            . "<cabecalho "
            . "xmlns=\"http://www.abrasf.org.br/nfse.xsd\" versao=\"$version\">"
            . "<versaoDados>$version</versaoDados>"
            . "</cabecalho>";
    }
}
